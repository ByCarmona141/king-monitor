<?php

namespace ByCarmona141\KingMonitor\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

use ByCarmona141\KingMonitor\Traits\HasTimeStatistics;
use ByCarmona141\KingMonitor\Traits\HasTimeHistorical;
use ByCarmona141\KingMonitor\Services\MonitorAlertService;

class KingMonitor extends Model
{
    use HasFactory, HasTimeStatistics, HasTimeHistorical;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'king_user_id',
        'tuple',
        'method',
        'endpoint',
        'headers',
        'token',
        'ip',
        'params',
        'code',
        'response',
        'response_size',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
        'code' => 'integer',
        'response_size' => 'integer',
    ];

    /**
     * Verificar si el usuario excedió el límite de peticiones.
     *
     * @return bool
     */
    public function hasExceededLimit(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $userId = auth()->id();
        $token = request()->bearerToken();
        $period = 'today';

        // Optimización: Consulta única con agregación para evitar N+1
        $stats = $this->queryForPeriod($period)
            ->selectRaw('
                COUNT(CASE WHEN king_user_id = ? THEN 1 END) as user_count,
                COUNT(CASE WHEN token = ? THEN 1 END) as token_count
            ', [$userId, $token])
            ->first();

        $userLimit = config('king-monitor.users.user_request_limit');
        $tokenLimit = config('king-monitor.users.token_request_limit');

        return ($stats->user_count ?? 0) >= $userLimit
            || ($stats->token_count ?? 0) >= $tokenLimit;
    }

    /**
     * Método principal de monitoreo.
     *
     * @param  mixed  $response
     * @param  string|null  $tuple
     * @return self
     */
    public function monitor($response, ?string $tuple = null): self
    {
        if ($tuple !== null && !is_string($tuple) && !is_numeric($tuple)) {
            logger()->warning('KingMonitor: Invalid tuple type', [
                'type' => gettype($tuple),
                'endpoint' => request()->path()
            ]);
            $tuple = null;
        }

        $this->fill([
            'king_user_id' => auth()->id(),
            'tuple' => $tuple,
            'method' => request()->method(),
            'endpoint' => request()->path(),
            'headers' => $this->sanitizeHeaders(request()->header()),
            'token' => request()->bearerToken(),
            'ip' => request()->getClientIp(),
            'params' => $this->sanitizeParams(request()->input()),
            'code' => $this->extractStatusCode($response),
            'response' => $this->extractResponse($response),
            'response_size' => $this->calculateResponseSize($response),
        ]);

        $this->save();

        $this->handleLimitsAndAlerts();

        return $this;
    }

    /**
     * Sanitiza los encabezados HTTP eliminando datos sensibles.
     *
     * @param  array|null  $headers
     * @return string|null
     */
    private function sanitizeHeaders(?array $headers): ?string
    {
        if (empty($headers)) {
            return null;
        }

        $sensitiveKeys = config('king-monitor.data_sensitivity.headers_keys');

        $sanitized = Arr::except($headers, $sensitiveKeys);

        return $this->safeJsonEncode($sanitized);
    }

    /**
     * Sanitiza los parámetros de la petición.
     *
     * @param  mixed  $params
     * @return string|null
     */
    private function sanitizeParams($params): ?string
    {
        if (empty($params)) {
            return null;
        }

        // Filtrar campos sensibles antes de codificar
        $sensitiveKeys = config('king-monitor.data_sensitivity.params_keys');
        $sanitized = Arr::except($params, $sensitiveKeys);

        return $this->safeJsonEncode($sanitized);
    }

    /**
     * Extrae el código de estado HTTP de la respuesta.
     *
     * @param  mixed  $response
     * @param  bool  $withoutResource
     * @return int|null
     */
    private function extractStatusCode($response): ?int
    {
        if (!$response) {
            return null;
        }

        // Estrategia 1: Respuesta HTTP nativa (Symfony/Laravel)
        if ($response instanceof SymfonyResponse) {
            return $this->extractFromSymfonyResponse($response);
        }

        // Estrategia 2: Objeto con método getStatusCode (fallback genérico)
        if (method_exists($response, 'getStatusCode')) {
            return $this->extractFromMethod($response);
        }

        // Estrategia 3: Conversión automática para Resources, Collections, arrays, etc.
        return $this->extractViaConversion($response);
    }

    /**
     * Extrae código de una respuesta Symfony/Laravel.
     *
     * @param  SymfonyResponse  $response
     * @return int|null
     */
    private function extractFromSymfonyResponse(SymfonyResponse $response): ?int
    {
        try {
            return $response->getStatusCode();
        } catch (\Throwable $e) {
            $this->logWarning('Failed to get status code from SymfonyResponse', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Extrae código mediante reflexión del método getStatusCode.
     *
     * @param  mixed  $response
     * @return int|null
     */
    private function extractFromMethod($response): ?int
    {
        try {
            $statusCode = $response->getStatusCode();
            return is_numeric($statusCode) ? (int) $statusCode : null;
        } catch (\Throwable $e) {
            $this->logWarning('Failed to call getStatusCode method', [
                'error' => $e->getMessage(),
                'response_type' => $this->getTypeName($response)
            ]);
            return null;
        }
    }

    /**
     * Intenta convertir la respuesta a HttpResponse para extraer el código.
     *
     * @param  mixed  $response
     * @return int|null
     */
    private function extractViaConversion($response): ?int
    {
        try {
            $httpResponse = $this->convertToHttpResponse($response);
            return $httpResponse?->getStatusCode();
        } catch (\Throwable $e) {
            $this->logWarning('Error converting response to HTTP for status extraction', [
                'error' => $e->getMessage(),
                'response_type' => $this->getTypeName($response)
            ]);
            return null;
        }
    }

    /**
     * Extrae el contenido de la respuesta para almacenamiento.
     *
     * @param  mixed  $response
     * @return string|null
     */
    private function extractResponse($response): ?string
    {
        if (!$response) {
            return null;
        }

        try {
            $content = $this->getResponseContent($response);

            if ($content === null) {
                return null;
            }

            $maxSize = config('king-monitor.response.size');
            $size = strlen($content);

            if ($size >= $maxSize) {
                return $this->safeJsonEncode([
                    'truncated' => true,
                    'original_size' => $size,
                    'max_allowed_size' => $maxSize,
                    'message' => 'Response exceeded allowed size',
                ]);
            }

            // Intentar decodificar JSON para almacenamiento legible
            $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            return $this->safeJsonEncode($decoded ?? $content);

        } catch (\JsonException $e) {
            $this->logWarning('JSON encoding error in extractResponse', [
                'error' => $e->getMessage(),
                'response_type' => $this->getTypeName($response)
            ]);

            return $this->safeJsonEncode([
                'error' => 'Unable to encode response content',
                'type' => $this->getTypeName($response)
            ]);
        } catch (\Throwable $e) {
            $this->logWarning('Unexpected error in extractResponse', [
                'error' => $e->getMessage(),
                'response_type' => $this->getTypeName($response)
            ]);

            return null;
        }
    }

    /**
     * Calcula el tamaño de la respuesta en bytes.
     *
     * @param  mixed  $response
     * @return int|null
     */
    private function calculateResponseSize($response): ?int
    {
        if (!$response) {
            return null;
        }

        try {
            $content = $this->getResponseContent($response);
            return $content !== null ? strlen($content) : null;
        } catch (\Throwable $e) {
            return null; // Falla silenciosa para no interrumpir el flujo
        }
    }

    /**
     * Convierte diferentes tipos de respuesta de Laravel a HttpResponse.
     *
     * @param  mixed  $response
     * @return SymfonyResponse|null
     */
    private function convertToHttpResponse($response): ?SymfonyResponse
    {
        return match (true) {
            // Ya es una respuesta HTTP
            $response instanceof SymfonyResponse => $response,

            // JsonResource: usar el request actual para la conversión
            $response instanceof JsonResource => $response->toResponse(request()),

            // Collection o array: JsonResponse
            $response instanceof Collection || is_array($response) => response()->json($response),

            // Valores escalares: respuesta básica
            is_string($response), is_numeric($response), is_bool($response) => response((string) $response),

            // Objeto genérico: intentar JSON como fallback
            is_object($response) => $this->convertObjectToJson($response),

            // No convertible
            default => null,
        };
    }

    /**
     * Intenta convertir un objeto genérico a JsonResponse.
     *
     * @param  object  $object
     * @return SymfonyResponse|null
     */
    private function convertObjectToJson(object $object): ?SymfonyResponse
    {
        try {
            return response()->json($object);
        } catch (\Throwable $e) {
            $this->logWarning('Failed to convert object to JSON response', [
                'error' => $e->getMessage(),
                'class' => get_class($object)
            ]);
            return null;
        }
    }

    /**
     * Obtiene el contenido de la respuesta independientemente del tipo.
     *
     * @param  mixed  $response
     * @return string|null
     */
    private function getResponseContent($response): ?string
    {
        // Si tiene método getContent, usarlo directamente
        if (method_exists($response, 'getContent')) {
            return $response->getContent();
        }

        // Si es convertible a HttpResponse, extraer contenido
        $httpResponse = $this->convertToHttpResponse($response);
        return $httpResponse?->getContent();
    }

    /**
     * Codifica a JSON de forma segura manejando excepciones.
     *
     * @param  mixed  $data
     * @return string|null
     */
    private function safeJsonEncode($data): ?string
    {
        if ($data === null) {
            return null;
        }

        if (is_string($data)) {
            return $data;
        }

        try {
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->logWarning('JSON encoding failed', [
                'error' => $e->getMessage(),
                'data_type' => gettype($data)
            ]);
            return null;
        }
    }

    /**
     * Obtiene el nombre del tipo de una variable para logging.
     *
     * @param  mixed  $value
     * @return string
     */
    private function getTypeName($value): string
    {
        if (is_object($value)) {
            return get_class($value);
        }

        return gettype($value);
    }

    /**
     * Registra un warning en el logger solo en entorno local.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    private function logWarning(string $message, array $context = []): void
    {
        if (app()->environment('local', 'testing')) {
            logger()->warning("KingMonitor: {$message}", $context);
        }
    }

    /**
     * Maneja los límites y genera alertas si es necesario.
     *
     * @return void
     */
    private function handleLimitsAndAlerts(): void
    {
        if (!$this->hasExceededLimit()) {
            return;
        }

        if (!config('king-monitor.alerts.enabled', true)) {
            return;
        }

        try {
            $alertService = app(MonitorAlertService::class);
            $alertService->handleExceededLimit('request');
        } catch (\Throwable $e) {
            $this->logWarning('Error handling alerts', ['error' => $e->getMessage()]);
        }
    }
}