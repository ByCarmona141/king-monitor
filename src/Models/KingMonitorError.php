<?php

namespace ByCarmona141\KingMonitor\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt; // Para encriptar los datos
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController; // Controlador de los Emails

class KingMonitorError extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'king_user_id',
        'king_type_action_id',
        'king_type_error_id',
        'origin',
        'method',
        'endpoint',
        'headers',
        'token',
        'ip',
        'params',
        'code',
        'error',
        'message',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
        'king_type_action_id' => 'integer',
        'king_type_error_id' => 'integer',
    ];

    public function kingTypeError(): BelongsTo {
        return $this->belongsTo(KingTypeError::class);
    }

    public function dateDiff($fecha1, $fecha2) {
        // Fecha inicial
        $fechaInicial = Carbon::parse($fecha1);

        // Fecha y hora actual
        $fechaActual = Carbon::parse($fecha2);

        // Calcular la diferencia en segundos
        return $fechaActual->diffInSeconds($fechaInicial);
    }

    // Funcion que retorna si se supero el limite de errores del usuario al día
    public function limit(): bool {
        try {
            $result = false;

            // Obtenemos la cantidad de registros hechos del dia por el usuario
            // Se obtiene primero los registros del dia y de esos registros se busca solo los que pertenecen al usuario
            // Si la cantidad de peticiones es mayor al limite
            if (KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('type', '=', 2)->where('king_user_id', '=', auth()->user()->id)->count() >= config('king-monitor.users.user_errors_limit')) {
                $result = true;
            }

            // Se obtienen los registros del dia y de esos registros se busca solo los que pertenecen al token del usuario
            // Si la cantidad de errores es mayor al limite
            if (KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('type', '=', 2)->where('token', '=', request()->bearerToken())->count() >= config('king-monitor.users.token_errors_limit')) {
                $result = true;
            }

            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    // Obtener los datos de cada dia
    public function statisticsDays() {
        try {
            $count = [
                'total' => KingMonitorError::all()->count(), // Cantidad de errores en total
                'method' => [
                    'mostCommon' => KingMonitorError::pluck('method')->mode(), // Metodo con la mayor cantidad de errores
                    'GET' => KingMonitorError::where('method', '=', 'GET')->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->count(),
                ],
                //'day' => KingMonitorError::all()->count(), // Día de la semana con la mayor cantidad de errores
                //'week' => , // Semana del mes con la mayor cantidad de errores
                //'month' => , // Mes del año con la mayor cantidad de errores
                //'trimester' => , // Trimestre del año con la mayor cantidad de errores
                //'year' => , // Año con la mayor cantidad de errores
                'user' => KingMonitorError::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores
                'days' => [
                    // Obtener la cantidad de errores por dia y el dia mas frecuente que da errores
                ]
            ];

            $response = [
                'total' => $count
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER ERROR STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (today)
    public function userErrorStatisticsToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de hoy del usuario
                //'lastMinute' => KingMonitor::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de peticiones en la ultima hora
                'method' => [ // Cantidad de peticiones en metodos del dia
                    'mostCommon' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del dia del usuario
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (today)
    public function userErrorMethodStatisticsToday($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (week)
    public function userErrorStatisticsWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de la semana
                //'lastDayWeek' => KingMonitor::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de peticiones en el ultimo dia de la semana
                'method' => [ // Total de peticiones en metodos de la semana
                    'mostCommon' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (week)
    public function userErrorMethodStatisticsWeek($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (month)
    public function userErrorStatisticsMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                //'lastWeekMonth' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de peticiones de la ultima semana del mes
                'method' => [ // Total de peticiones en metodos del mes
                    'mostCommon' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (month)
    public function userErrorMethodStatisticsMonth($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (quarter)
    public function userErrorStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                //'lastMonthQuarter' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfQuarter()->subMonth(2),
                //    Carbon::now()->endOfQuarter()
                //])->count(), // Cantidad de peticiones del ultimo mes del trimestre
                'method' => [ // Total de peticiones en metodos del trimestre
                    'mostCommon' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (quarter)
    public function userErrorMethodStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (year)
    public function userErrorStatisticsYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'method' => [ // Cantidad de peticiones a metodos del año
                    'mostCommon' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (year)
    public function userErrorMethodStatisticsYear($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (total)
    public function userErrorStatisticsTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones en total
                'method' => [
                    'mostCommon' => KingMonitorError::where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones
                    'GET' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                    'POST' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
                ]
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (total)
    public function userErrorMethodStatisticsTotal($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                'POST' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                'PUT' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de errores (today)
    public function errorStatisticsToday() {
        try {
            $response = [
                'total' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->count(), // Cantidad de errores de hoy
                //'lastMinute' => KingMonitorError::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de errores en la ultima hora
                'method' => [ // Cantidad de errores en metodos del dia
                    'mostCommon' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del dia
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                ],
                'user' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del dia
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (today)
    public function errorMethodStatisticsToday() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (today)
    public function errorStatisticsFrequentUserToday() {
        try {
            $response = [
                'user' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del dia
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de errores (week)
    public function errorStatisticsWeek() {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Cantidad de errores de la semana
                //'lastDayWeek' => KingMonitorError::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de errores en el ultimo dia de la semana
                'method' => [ // Total de errores en metodos de la semana
                    'mostCommon' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                ],
                'user' =>  KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores de la semana
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (week)
    public function errorMethodStatisticsWeek() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (week)
    public function errorStatisticsFrequentUserWeek() {
        try {
            $response = [
                'user' =>  KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores de la semana
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de errores (month)
    public function errorStatisticsMonth() {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Cantidad de errores del mes
                //'lastWeekMonth' => KingMonitorError::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de errores de la ultima semana del mes
                'method' => [ // Total de errores en metodos del mes
                    'mostCommon' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del mes
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                ],
                'user' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del mes
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (month)
    public function errorMethodStatisticsMonth() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (month)
    public function errorStatisticsFrequentUserMonth() {
        try {
            $response = [
                'user' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del mes
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de errores (quarter)
    public function errorStatisticsQuarter() {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Cantidad de errores del trimestre
                //'lastWeekMonth' => KingMonitorError::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de errores de la ultima semana del mes
                'method' => [ // Total de errores en metodos del mes
                    'mostCommon' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del trimestre
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                ],
                'user' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del trimestre
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (quarter)
    public function errorMethodStatisticsQuarter() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (quarter)
    public function errorStatisticsFrequentUserQuarter() {
        try {
            $response = [
                'user' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del trimestre
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de errores (year)
    public function errorStatisticsYear() {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->count(), // Cantidad de errores del año
                'method' => [ // Cantidad de errores a metodos del año
                    'mostCommon' => KingMonitorError::whereYear('created_at', '=', now())->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del año
                    'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
                ],
                'user' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del año
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (year)
    public function errorMethodStatisticsYear() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (year)
    public function errorStatisticsFrequentUserYear() {
        try {
            $response = [
                'user' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores del trimestre
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de errores (total)
    public function errorStatisticsTotal() {
        try {
            $response = [
                'total' => KingMonitorError::all()->count(), // Cantidad de errores en total
                'method' => [
                    'mostCommon' => KingMonitorError::pluck('method')->mode(), // Metodo con la mayor cantidad de errores
                    'GET' => KingMonitorError::where('method', '=', 'GET')->count(),
                    'POST' => KingMonitorError::where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitorError::where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->count(),
                ],
                'user' => KingMonitorError::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de errores
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (total)
    public function errorMethodStatisticsTotal() {
        try {
            $response = [
                'GET' => KingMonitorError::where('method', '=', 'GET')->count(),
                'POST' => KingMonitorError::where('method', '=', 'POST')->count(),
                'PUT' => KingMonitorError::where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitorError::where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitorError::where('method', '=', 'DELETE')->count(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de errores (total)
    public function errorStatisticsFrequentUserTotal() {
        try {
            $response = [
                'user' => KingMonitorError::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ******************************************************************/
    public function userErrorStatistics($kingUserId) {
        try {
            $today = $this->userErrorStatisticsToday($kingUserId);
            $week = $this->userErrorStatisticsWeek($kingUserId);
            $month = $this->userErrorStatisticsMonth($kingUserId);
            $quarter = $this->userErrorStatisticsQuarter($kingUserId);
            $year = $this->userErrorStatisticsYear($kingUserId);
            $total = $this->userErrorStatisticsTotal($kingUserId);

            $response = [
                'today' => $today,
                'week' => $week,
                'month' => $month,
                'quarter' => $quarter,
                'year' => $year,
                'total' => $total,
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function errorStatistics() {
        try {
            $today = $this->errorStatisticsToday();
            $week = $this->errorStatisticsWeek();
            $month = $this->errorStatisticsMonth();
            $quarter = $this->errorStatisticsQuarter();
            $year = $this->errorStatisticsYear();
            $total = $this->errorStatisticsTotal();

            $response = [
                'today' => $today,
                'week' => $week,
                'month' => $month,
                'quarter' => $quarter,
                'year' => $year,
                'total' => $total,
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ENDPOINT ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINT TOTAL ----------------------------------------------------------------
    // Obtener los endpoints con mayor cantidad de peticiones y errores (aun hace falta)
    public function errorStatisticsEndpointTotal() {
        try {
            $response = [];

            // Route::getRoutes()
            foreach (config('king-monitor.monitor.endpoint_statistics') as $endpoint) {
                // Arreglo con la cantidad de peticiones del dia
                $response[] = [
                    'name' => $endpoint,
                    'total' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->count(),
                    'method' => [ // Total de metodos ocupados de hoy
                        'GET' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'GET')->count(),
                        'POST' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'POST')->count(),
                        'PUT' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'PUT')->count(),
                        'PATCH' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'PATCH')->count(),
                        'DELETE' => KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'DELETE')->count(),
                    ],
                    'user' =>  KingMonitorError::where('endpoint', 'like', $endpoint . '%')->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de peticiones
                ];
            }

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    // Historico del usuario por dia dividido en horas (today)
    public function userErrorHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por semana dividido en dias (week)
    public function userErrorHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por mes dividido en dias (month)
    public function userErrorHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por trimestre dividido en dias (quarter)
    public function userErrorHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por año dividido en dias (year)
    public function userErrorHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por total dividido en años (total)
    public function userErrorHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorError::where('king_user_id', '=', $kingUserId)->count(), // Total de errores del usuario
                'details' => KingMonitorError::where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    // Historico por dia dividido en horas (today)
    public function errorHistoricalToday() {
        try {
            $response = [
                'total' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de errores
                'details' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por semana dividido en dias (week)
    public function errorHistoricalWeek() {
        try {
            $response = [
                'total' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Total de errores
                'details' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por mes dividido en dias (month)
    public function errorHistoricalMonth() {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de errores
                'details' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por trimestre dividido en dias (quarter)
    public function errorHistoricalQuarter() {
        try {
            $response = [
                'total' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Total de errores
                'details' => KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por año dividido en dias (year)
    public function errorHistoricalYear() {
        try {
            $response = [
                'total' => KingMonitorError::whereYear('created_at', '=', now())->count(), // Total de errores
                'details' => KingMonitorError::whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por total dividido en años (total)
    public function errorHistoricalTotal() {
        try {
            $response = [
                'total' => KingMonitorError::all()->count(), // Total de errores
                'details' => KingMonitorError::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function userErrorHistorical($kingUserId) {
        try {
            $today = $this->userErrorHistoricalToday($kingUserId);
            $week = $this->userErrorHistoricalWeek($kingUserId);
            $month = $this->userErrorHistoricalMonth($kingUserId);
            $quarter = $this->userErrorHistoricalQuarter($kingUserId);
            $year = $this->userErrorHistoricalYear($kingUserId);
            $total = $this->userErrorHistoricalTotal($kingUserId);

            $response = [
                'today' => $today,
                'week' => $week,
                'month' => $month,
                'quarter' => $quarter,
                'year' => $year,
                'total' => $total,
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function errorHistorical() {
        try {
            $today = $this->errorHistoricalToday();
            $week = $this->errorHistoricalWeek();
            $month = $this->errorHistoricalMonth();
            $quarter = $this->errorHistoricalQuarter();
            $year = $this->errorHistoricalYear();
            $total = $this->errorHistoricalTotal();

            $response = [
                'today' => $today,
                'week' => $week,
                'month' => $month,
                'quarter' => $quarter,
                'year' => $year,
                'total' => $total,
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** AVG ERROR ******************************************************************/
    public function averageErrorTimeToday() {
        try {
            $time = KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageErrorTimeWeek() {
        try {
            $time = KingMonitorError::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageErrorTimeMonth() {
        try {
            $time = KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageErrorTimeQuarter() {
        try {
            $time = KingMonitorError::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageErrorTimeYear() {
        try {
            $time = KingMonitorError::whereYear('created_at', '=', now())->orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageErrorTimeTotal() {
        try {
            $time = KingMonitorError::orderBy('created_at', 'asc')->get();

            $intervals = [];

            // Calcular los intervalos
            for ($i = 1; $i < count($time); $i++) {
                $intervals[] = $time[$i]->created_at->diffInSeconds($time[$i - 1]->created_at); // Agregar el intervalo al array
            }

            // Calcular el promedio
            if (!empty($intervals)) {
                $averageInterval = array_sum($intervals) / count($intervals); // Promedio en segundos
            } else {
                $averageInterval = null; // No hay intervalos para calcular
            }

            $response = [
                'min' => (!empty($intervals)) ? min($intervals) : null,
                'avg' => $averageInterval,
                'max' => (!empty($intervals)) ? max($intervals) : null
            ];

            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- MONITOR ----------------------------------------------------------------
    // Guardamos los errores en el monitor (Es lo mismo que el metodo monitor de KingMonitorError)
    public function monitor($king_type_error_id, $error = NULL, $message = NULL) {
        try {
            // Guardar los datos en la base de datos
            $king_monitor_errors = new KingMonitorError();

            $king_monitor_errors->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
            $king_monitor_errors->king_type_error_id = $king_type_error_id;
            $king_monitor_errors->method = request()->method();
            $king_monitor_errors->endpoint = request()->path();
            $king_monitor_errors->headers = (request()->header() === NULL) ? NULL : json_encode(Arr::except(request()->header(), ['authorization'])); // Mandamos los headers sin el authorization que es donde esta el token
            $king_monitor_errors->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
            $king_monitor_errors->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
            $king_monitor_errors->params = (request()->input() === NULL || request()->input() === []) ? NULL : json_encode(request()->input()); // Crypt::encryptString(json_encode($request->input()));
            $king_monitor_errors->code = ($error === NULL) ? NULL : (($error->getStatusCode() == NULL) ? NULL : $error->getStatusCode()); // Codigo HTTP
            $king_monitor_errors->error = ($error === NULL) ? NULL : $error->getCode(); // Crypt::encryptString(json_encode($request->input()));
            $king_monitor_errors->message = ($message === NULL) ? (($error === NULL) ? NULL : $error->getMessage()) : $message; // Crypt::encryptString(json_encode($request->input()));
            // ($error === NULL) ? (($message === NULL) ? NULL : $message) : $error->getMessage();

            // Guardamos los datos en la bd
            $king_monitor_errors->save();

            // Si el usuario supero el limite de errores
            if ($king_monitor_errors->limit()) {
                $king_monitor_alert = new KingMonitorAlert();

                // Guardamos el usuario que supero el limite de errores en KingMonitorUserExceeded
                $king_monitor_user_excededs = new KingMonitorUserExceeded();

                // Si el usuario no ha sido registrado en la tabla KingMonitorUserExceeded
                if(!$king_monitor_user_excededs->limit()) {
                    $king_monitor_user_excededs->type = 2; // error
                    $king_monitor_user_excededs->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
                    $king_monitor_user_excededs->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                    $king_monitor_user_excededs->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                    $king_monitor_user_excededs->save(); // Guardamos los datos en la bd
                }

                // Si el monitor tiene las alertas activadas
                if (config('king-monitor.alerts.monitor_alert')) {
                    // Si no existe la ultima alerta
                    if ($king_monitor_alert->lastAlertToday() === NULL) {
                        // Mandar una alerta al encargado
                        $mailController = new KingMonitorMailController();
                        $mailController->sendAlertLimitError();

                        // Guardamos la alerta
                        $king_monitor_alert->king_user_id = auth()->user()->id;
                        $king_monitor_alert->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                        $king_monitor_alert->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                        $king_monitor_alert->save();
                    } else {
                        // Obtenemos los segundos transcurridos
                        $seconds = $this->dateDiff($king_monitor_alert->lastAlertToday()->created_at, now());

                        // Si los segundos transcurridos son mayores al tiempo entre alertas
                        if($seconds > config('king-monitor.alerts.user_between_alert')) {
                            // Mandar una alerta al encargado
                            $mailController = new KingMonitorMailController();
                            $mailController->sendAlertLimitError();

                            // Guardamos la alerta
                            $king_monitor_alert->king_user_id = auth()->user()->id;
                            $king_monitor_alert->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                            $king_monitor_alert->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                            $king_monitor_alert->save();
                        }
                    }
                }
            }

            return $king_monitor_errors;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function monitorErrorUnauthenticated($king_type_error_id, $error = NULL, $message = NULL) {
        try {
            // Guardar los datos en la base de datos
            $king_monitor_errors = new KingMonitorError();

            $king_monitor_errors->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
            $king_monitor_errors->king_type_error_id = $king_type_error_id;
            $king_monitor_errors->method = request()->method();
            $king_monitor_errors->endpoint = request()->path();
            $king_monitor_errors->headers = (request()->header() === NULL) ? NULL : json_encode(Arr::except(request()->header(), ['authorization'])); // Mandamos los headers sin el authorization que es donde esta el token
            $king_monitor_errors->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
            $king_monitor_errors->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
            $king_monitor_errors->params = (request()->input() === NULL || request()->input() === []) ? NULL : json_encode(request()->input()); // Crypt::encryptString(json_encode($request->input()));
            $king_monitor_errors->code = 401; // Codigo HTTP
            $king_monitor_errors->error = ($error === NULL) ? NULL : $error->getCode(); // Crypt::encryptString(json_encode($request->input()));
            $king_monitor_errors->message = ($message === NULL) ? (($error === NULL) ? NULL : $error->getMessage()) : $message; // Crypt::encryptString(json_encode($request->input()));
            // ($error === NULL) ? (($message === NULL) ? NULL : $message) : $error->getMessage();

            // Guardamos los datos en la bd
            $king_monitor_errors->save();

            $king_monitor_alert = new KingMonitorAlert();

            // Guardamos el usuario que supero el limite de errores en KingMonitorUserExceeded
            $king_monitor_user_excededs = new KingMonitorUserExceeded();

            // Si el usuario no ha sido registrado en la tabla KingMonitorUserExceeded
            if(!$king_monitor_user_excededs->limit()) {
                $king_monitor_user_excededs->type = 2; // error
                $king_monitor_user_excededs->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
                $king_monitor_user_excededs->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                $king_monitor_user_excededs->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                $king_monitor_user_excededs->save(); // Guardamos los datos en la bd
            }

            // Si el monitor tiene las alertas activadas
            if (config('king-monitor.alerts.monitor_alert')) {
                $mailController = new KingMonitorMailController();
                $mailController->sendAlertUnauthenticated();

                // Guardamos la alerta
                $king_monitor_alert->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
                $king_monitor_alert->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                $king_monitor_alert->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                $king_monitor_alert->save();
            }

            return $king_monitor_errors;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Obtenemos los errores generados
    public function errors() {

    }
}
