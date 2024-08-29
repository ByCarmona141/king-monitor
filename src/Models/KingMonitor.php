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

// Controlador de los Emails
use ByCarmona141\KingMonitor\Http\Controllers\API\KingMonitorMailController;

class KingMonitor extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'king_user_id',
        'king_type_action_id',
        'origin',
        'tuple',
        'method',
        'endpoint',
        'headers',
        'ip',
        'params',
        'code',
        'response',
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
    ];

    // Funcion que retorna si se supero el limite de peticiones del usuario al día
    public function limit(): bool {
        try {
            $result = false;

            // Obtenemos la cantidad de registros hechos del dia por el usuario
            // Se obtiene primero los registros del dia y de esos registros se busca solo los que pertenecen al usuario
            // Si la cantidad de peticiones es mayor al limite
            if (KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', auth()->user()->id)->count() >= config('king-monitor.users.user_request_limit')) {
                $result = true;
            }

            // Se obtienen los registros del dia y de esos registros se busca solo los que pertenecen al token del usuario
            // Si la cantidad de peticiones es mayor al limite
            if (KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('token', '=', request()->bearerToken())->count() >= config('king-monitor.users.token_request_limit')) {
                $result = true;
            }

            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Obtenemos los errores generados
    public function errors() {

    }

    public function dateDiff($fecha1, $fecha2) {
        // Fecha inicial
        $fechaInicial = Carbon::parse($fecha1);

        // Fecha y hora actual
        $fechaActual = Carbon::parse($fecha2);

        // Calcular la diferencia en segundos
        return $fechaActual->diffInSeconds($fechaInicial);
    }

    /****************************************************************** KING_MONITORS ******************************************************************/
    /****************************************************************** STATISTICS ******************************************************************/
    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de un usuario (today)
    public function userStatisticsToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de hoy del usuario
                //'lastMinute' => KingMonitor::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de peticiones en la ultima hora
                'method' => [ // Cantidad de peticiones en metodos del dia
                    //'mostCommon' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del dia del usuario
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (today)
    public function userMethodStatisticsToday($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de un usuario (week)
    public function userStatisticsWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de la semana
                //'lastDayWeek' => KingMonitor::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de peticiones en el ultimo dia de la semana
                'method' => [ // Total de peticiones en metodos de la semana
                    /*
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    */
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (week)
    public function userMethodStatisticsWeek($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de un usuario (month)
    public function userStatisticsMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                //'lastWeekMonth' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de peticiones de la ultima semana del mes
                'method' => [ // Total de peticiones en metodos del mes
                    //'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode() + KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (month)
    public function userMethodStatisticsMonth($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de un usuario (quarter)
    public function userStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                //'lastMonthQuarter' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfQuarter()->subMonth(2),
                //    Carbon::now()->endOfQuarter()
                //])->count(), // Cantidad de peticiones del ultimo mes del trimestre
                'method' => [ // Total de peticiones en metodos del trimestre
                    /*
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    */
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count() +
                        KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (quarter)
    public function userMethodStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de un usuario (year)
    public function userStatisticsYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'method' => [ // Cantidad de peticiones a metodos del año
                    //'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (year)
    public function userMethodStatisticsYear($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de un usuario (total)
    public function userStatisticsTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::where('king_user_id', '=', $kingUserId)->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones en total
                'method' => [
                    //'mostCommon' => KingMonitor::where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones
                    'GET' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                    'POST' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (total)
    public function userMethodStatisticsTotal($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                'POST' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                'PUT' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count() + KingMonitorError::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** REQUEST STATISTICS ******************************************************************/
    /****************************************************************** USER REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (today)
    public function userRequestStatisticsToday($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (today)
    public function userRequestMethodStatisticsToday($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (week)
    public function userRequestStatisticsWeek($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (week)
    public function userRequestMethodStatisticsWeek($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (month)
    public function userRequestStatisticsMonth($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (month)
    public function userRequestMethodStatisticsMonth($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (quarter)
    public function userRequestStatisticsQuarter($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (quarter)
    public function userRequestMethodStatisticsQuarter($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (year)
    public function userRequestStatisticsYear($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (year)
    public function userRequestMethodStatisticsYear($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (total)
    public function userRequestStatisticsTotal($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (total)
    public function userRequestMethodStatisticsTotal($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestMethodStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de peticiones (today)
    public function requestStatisticsToday() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (today)
    public function requestMethodStatisticsToday() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (today)
    public function requestStatisticsFrequentUserToday() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de peticiones (week)
    public function requestStatisticsWeek() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (week)
    public function requestMethodStatisticsWeek() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (week)
    public function requestStatisticsFrequentUserWeek() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de peticiones (month)
    public function requestStatisticsMonth() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (month)
    public function requestMethodStatisticsMonth() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (month)
    public function requestStatisticsFrequentUserMonth() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de peticiones (quarter)
    public function requestStatisticsQuarter() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (quarter)
    public function requestMethodStatisticsQuarter() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (quarter)
    public function requestStatisticsFrequentUserQuarter() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de peticiones (year)
    public function requestStatisticsYear() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (year)
    public function requestMethodStatisticsYear() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (year)
    public function requestStatisticsFrequentUserYear() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de peticiones (total)
    public function requestStatisticsTotal() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (total)
    public function requestMethodStatisticsTotal() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestMethodStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (total)
    public function requestStatisticsFrequentUserTotal() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsFrequentUserTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** KING_MONITOR_ERRORS ******************************************************************/
    /****************************************************************** ERROR STATISTICS ******************************************************************/
    /****************************************************************** USER ERROR STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER ERROR STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (today)
    public function userErrorStatisticsToday($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (today)
    public function userErrorMethodStatisticsToday($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERRORS STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (week)
    public function userErrorStatisticsWeek($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (week)
    public function userErrorMethodStatisticsWeek($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERRORS STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (month)
    public function userErrorStatisticsMonth($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (month)
    public function userErrorMethodStatisticsMonth($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (quarter)
    public function userErrorStatisticsQuarter($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (quarter)
    public function userErrorMethodStatisticsQuarter($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (year)
    public function userErrorStatisticsYear($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (year)
    public function userErrorMethodStatisticsYear($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de errores de un usuario (total)
    public function userErrorStatisticsTotal($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP de un usuario (total)
    public function userErrorMethodStatisticsTotal($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorMethodStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** ERROR STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- ERROR STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de errores (today)
    public function errorStatisticsToday() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (today)
    public function errorMethodStatisticsToday() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (today)
    public function errorStatisticsFrequentUserToday() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de errores (week)
    public function errorStatisticsWeek() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (week)
    public function errorMethodStatisticsWeek() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (week)
    public function errorStatisticsFrequentUserWeek() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas de errores (month)
    public function errorStatisticsMonth() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (month)
    public function errorMethodStatisticsMonth() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (month)
    public function errorStatisticsFrequentUserMonth() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas de errores (quarter)
    public function errorStatisticsQuarter() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (quarter)
    public function errorMethodStatisticsQuarter() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (quarter)
    public function errorStatisticsFrequentUserQuarter() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de errores (year)
    public function errorStatisticsYear() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (year)
    public function errorMethodStatisticsYear() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (year)
    public function errorStatisticsFrequentUserYear() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de errores (total)
    public function errorStatisticsTotal() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores de los metodos HTTP (total)
    public function errorMethodStatisticsTotal() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorMethodStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario mas comun de errores (total)
    public function errorStatisticsFrequentUserTotal() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsFrequentUserTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ENDPOINTS ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS ENDPOINTS ----------------------------------------------------------------
    // Obtener los endpoints con mayor cantidad de peticiones (aun hace falta)
    public function requestStatisticsEndpointTotal() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatisticsEndpointTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS ENDPOINTS ----------------------------------------------------------------
    // Obtener los endpoints con mayor cantidad de errores (aun hace falta)
    public function errorStatisticsEndpointTotal() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatisticsEndpointTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas (today)
    public function statisticsToday() {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->count(),
                //'lastMinute' => KingMonitor::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de peticiones en la ultima hora
                'method' => [
                    // 'mostCommon' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                ],
                'user' => [
                    'request' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                    'error' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (today)
    public function methodStatisticsToday() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count() + KingMonitorError::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones y errores (today)
    public function statisticsFrequentUserToday() {
        try {
            $response = [
                'request' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS WEEK ----------------------------------------------------------------
    // Estadisticas de peticiones (week)
    public function statisticsWeek() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                //'lastDayWeek' => KingMonitor::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de peticiones en el ultimo dia de la semana
                'method' => [ // Total de peticiones en metodos de la semana
                    /*
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->pluck('method')->mode(),
                    */
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ])->count(),
                ],
                'user' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode()
                ],
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (week)
    public function methodStatisticsWeek() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones y errores (week)
    public function statisticsFrequentUserWeek() {
        try {
            $response = [
                'request' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS MONTH ----------------------------------------------------------------
    // Estadisticas (month)
    public function statisticsMonth() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                //'lastWeekMonth' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de peticiones de la ultima semana del mes
                'method' => [
                    //'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                ],
                'user' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de peticiones del mes
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de peticiones del mes
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (month)
    public function methodStatisticsMonth() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones y errores (month)
    public function statisticsFrequentUserMonth() {
        try {
            $response = [
                'request' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER ----------------------------------------------------------------
    // Estadisticas (quarter)
    public function statisticsQuarter() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                //'lastMonthQuarter' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfQuarter()->subMonth(2),
                //    Carbon::now()->endOfQuarter()
                //])->count(), // Cantidad de peticiones del ultimo mes del trimestre
                'method' => [
                    /*
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->pluck('method')->mode(),
                    */
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count() +
                        KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                            Carbon::now()->startOfQuarter(),
                            Carbon::now()->endOfQuarter()
                        ])->count(),
                ],
                'user' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (quarter)
    public function methodStatisticsQuarter() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones y errores (quarter)
    public function statisticsFrequentUserQuarter() {
        try {
            $response = [
                'request' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitorError::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de peticiones (year)
    public function statisticsYear() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->count() + KingMonitorError::whereYear('created_at', '=', now())->count(),
                'method' => [
                    //'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
                ],
                'user' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (year)
    public function methodStatisticsYear() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count() + KingMonitorError::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones y errores (year)
    public function statisticsFrequentUserYear() {
        try {
            $response = [
                'request' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas (total)
    public function statisticsTotal() {
        try {
            $response = [
                'total' => KingMonitor::all()->count() + KingMonitorError::all()->count(),
                'method' => [
                    //'mostCommon' => KingMonitor::pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->count() + KingMonitorError::where('method', '=', 'GET')->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->count() + KingMonitorError::where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->count() + KingMonitorError::where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->count() + KingMonitorError::where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->count() + KingMonitorError::where('method', '=', 'DELETE')->count(),
                ],
                'user' => [
                    'request' => KingMonitor::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                    'error' => KingMonitorError::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                ],
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (total)
    public function methodStatisticsTotal() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->count() + KingMonitorError::where('method', '=', 'GET')->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->count() + KingMonitorError::where('method', '=', 'POST')->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->count() + KingMonitorError::where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->count() + KingMonitorError::where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->count() + KingMonitorError::where('method', '=', 'DELETE')->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (total)
    public function statisticsFrequentUserTotal() {
        try {
            $response = [
                'request' => KingMonitor::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
                'error' => KingMonitor::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // Desglose de estadisticas de peticiones del usuario
    public function userRequestStatistics($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestStatistics($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de errores del usuario
    public function userErrorStatistics($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorStatistics($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de peticiones
    public function requestStatistics() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestStatistics()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de errores
    public function errorStatistics() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorStatistics()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de peticiones y errores del usuario
    public function userStatistics($kingUserId) {
        try {
            $response = [
                'request' => $this->userRequestStatistics($kingUserId)->original,
                'errors' => $this->userErrorStatistics($kingUserId)->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de peticiones y errores
    public function statistics() {
        try {
            $response = [
                'request' => $this->requestStatistics()->original,
                'errors' => $this->errorStatistics()->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** KINGMONITOR_USER_EXCEEDED ******************************************************************/
    /****************************************************************** USER STATISTICS EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas del usuario que excede el limite de peticiones (today)
    public function userRequestStatisticsExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de peticiones (week)
    public function userRequestStatisticsExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de peticiones (month)
    public function userRequestStatisticsExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de peticiones (quarter)
    public function userRequestStatisticsExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de peticiones (year)
    public function userRequestStatisticsExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de peticiones (total)
    public function userRequestStatisticsExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas del usuario que excede el limite de errores (today)
    public function userErrorStatisticsExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de errores (week)
    public function userErrorStatisticsExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de errores (month)
    public function userErrorStatisticsExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de errores (quarter)
    public function userErrorStatisticsExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de errores (year)
    public function userErrorStatisticsExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas del usuario que excede el limite de errores (total)
    public function userErrorStatisticsExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas de errores y peticiones del usuario que excede el limite (today)
    public function userStatisticsExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores y peticiones del usuario que excede el limite (week)
    public function userStatisticsExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores y peticiones del usuario que excede el limite (month)
    public function userStatisticsExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores y peticiones del usuario que excede el limite (quarter)
    public function userStatisticsExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores y peticiones del usuario que excede el limite (year)
    public function userStatisticsExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de errores y peticiones del usuario que excede el limite (total)
    public function userStatisticsExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatistics($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ----------------------------------------------------------------
    // Desglose de estadisticas de peticiones excedidas del usuario
    public function userRequestStatisticsExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatistics($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de errores excedidos del usuario
    public function userErrorStatisticsExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestStatistics($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de peticiones y errores excedidos del usuario
    public function userStatisticsExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userStatistics($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas de usuarios que exceden el limite de peticiones (today)
    public function requestStatisticsExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones (week)
    public function requestStatisticsExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones (month)
    public function requestStatisticsExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones (quarter)
    public function requestStatisticsExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones (year)
    public function requestStatisticsExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones (total)
    public function requestStatisticsExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas de usuarios que exceden el limite de errores (today)
    public function errorStatisticsExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de errores (week)
    public function errorStatisticsExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de errores (month)
    public function errorStatisticsExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de errores (quarter)
    public function errorStatisticsExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de errores (year)
    public function errorStatisticsExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de errores (total)
    public function errorStatisticsExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ----------------------------------------------------------------
    // Estadisticas de usuarios que exceden el limite de peticiones y errores (today)
    public function statisticsExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones y errores (week)
    public function statisticsExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones y errores (month)
    public function statisticsExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones y errores (quarter)
    public function statisticsExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones y errores (year)
    public function statisticsExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de usuarios que exceden el limite de peticiones y errores (total)
    public function statisticsExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS EXCEEDED ----------------------------------------------------------------
    // Desglose de estadisticas de usuarios que exceden el limite de peticiones
    public function requestStatisticsExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestStatistics()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de usuarios que exceden el limite de errores
    public function errorStatisticsExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorStatistics()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de usuarios que exceden el limite de peticiones y errores
    public function statisticsExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->statistics()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** USER HISTORICAL EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico del usuario que excede el limite de peticiones (today)
    public function userRequestHistoricalExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones (week)
    public function userRequestHistoricalExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones (month)
    public function userRequestHistoricalExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones (quarter)
    public function userRequestHistoricalExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones (year)
    public function userRequestHistoricalExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones (total)
    public function userRequestHistoricalExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico del usuario que excede el limite de errores (today)
    public function userErrorHistoricalExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de errores (week)
    public function userErrorHistoricalExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de errores (month)
    public function userErrorHistoricalExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de errores (quarter)
    public function userErrorHistoricalExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de errores (year)
    public function userErrorHistoricalExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de errores (total)
    public function userErrorHistoricalExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico del usuario que excede el limite de peticiones y errores (today)
    public function userHistoricalExceededToday($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones y errores (week)
    public function userHistoricalExceededWeek($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones y errores (month)
    public function userHistoricalExceededMonth($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones y errores (quarter)
    public function userHistoricalExceededQuarter($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones y errores (year)
    public function userHistoricalExceededYear($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario que excede el limite de peticiones y errores (total)
    public function userHistoricalExceededTotal($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Desglose del historico de usuarios que exceden el limite de peticiones
    public function userRequestHistoricalExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userRequestHistorical($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose del historico de usuarios que exceden el limite de errores
    public function userErrorHistoricalExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userErrorHistorical($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose del historico de usuarios que exceden el limite de peticiones y errores
    public function userHistoricalExceeded($kingUserId) {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->userHistorical($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL EXCEEDED ******************************************************************/
    // ---------------------------------------------------------------- REQUEST HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico de usuarios que exceden el limite de peticiones (today)
    public function requestHistoricalExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones (week)
    public function requestHistoricalExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones (month)
    public function requestHistoricalExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones (quarter)
    public function requestHistoricalExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones (year)
    public function requestHistoricalExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones (total)
    public function requestHistoricalExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistoricalTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico de usuarios que exceden el limite de errores (today)
    public function errorHistoricalExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de errores (week)
    public function errorHistoricalExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de errores (month)
    public function errorHistoricalExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de errores (quarter)
    public function errorHistoricalExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de errores (year)
    public function errorHistoricalExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de errores (total)
    public function errorHistoricalExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistoricalTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Historico de usuarios que exceden el limite de peticiones y errores (today)
    public function historicalExceededToday() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones y errores (week)
    public function historicalExceededWeek() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones y errores (month)
    public function historicalExceededMonth() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones y errores (quarter)
    public function historicalExceededQuarter() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones y errores (year)
    public function historicalExceededYear() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de usuarios que exceden el limite de peticiones y errores (total)
    public function historicalExceededTotal() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historicalTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL EXCEEDED ----------------------------------------------------------------
    // Desglose del historico de usuarios que exceden el limite de peticiones
    public function requestHistoricalExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->requestHistorical()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de usuarios que exceden el limite de errores
    public function errorHistoricalExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->errorHistorical()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Desglose de estadisticas de usuarios que exceden el limite de peticiones y errores
    public function historicalExceeded() {
        try {
            $king = new KingMonitorUserExceeded();
            $response = $king->historical()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** KING_MONITOR_ALERT ******************************************************************/
    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS ALERTS ----------------------------------------------------------------
    // Estadisticas de alertas del usuario (today)
    public function userStatisticsAlertToday($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de alertas del usuario (week)
    public function userStatisticsAlertWeek($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de alertas del usuario (month)
    public function userStatisticsAlertMonth($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de alertas del usuario (quarter)
    public function userStatisticsAlertQuarter($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de alertas del usuario (year)
    public function userStatisticsAlertYear($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de alertas del usuario (total)
    public function userStatisticsAlertTotal($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userStatisticsTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS ALERTS ----------------------------------------------------------------
    // Total de alertas (today)
    public function statisticsAlertToday() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (week)
    public function statisticsAlertWeek() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (month)
    public function statisticsAlertMonth() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (quarter)
    public function statisticsAlertQuarter() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (year)
    public function statisticsAlertYear() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (total)
    public function statisticsAlertTotal() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->statisticsTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL ALERTS ----------------------------------------------------------------
    // Historico de alertas del usuario (today)
    public function userHistoricalAlertToday($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (week)
    public function userHistoricalAlertWeek($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (month)
    public function userHistoricalAlertMonth($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (quarter)
    public function userHistoricalAlertQuarter($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (year)
    public function userHistoricalAlertYear($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (total)
    public function userHistoricalAlertTotal($kingUserId) {
        try {
            $king = new KingMonitorAlert();
            $response = $king->userHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL ALERTS ----------------------------------------------------------------
    // Total de alertas (today)
    public function historicalAlertToday() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (week)
    public function historicalAlertWeek() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (month)
    public function historicalAlertMonth() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (quarter)
    public function historicalAlertQuarter() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (year)
    public function historicalAlertYear() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (total)
    public function historicalAlertTotal() {
        try {
            $king = new KingMonitorAlert();
            $response = $king->historicalTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** KING_MONITOR ******************************************************************/
    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL ----------------------------------------------------------------
    // Historico del usuario por dia dividido en horas (today)
    public function userRequestHistoricalToday($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por semana dividido en dias (week)
    public function userRequestHistoricalWeek($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por mes dividido en dias (month)
    public function userRequestHistoricalMonth($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por trimestre dividido en dias (quarter)
    public function userRequestHistoricalQuarter($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por año dividido en dias (year)
    public function userRequestHistoricalYear($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por total dividido en años (total)
    public function userRequestHistoricalTotal($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR HISTORICAL ----------------------------------------------------------------
    // Historico del usuario por dia dividido en horas (today)
    public function userErrorHistoricalToday($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalToday($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por semana dividido en dias (week)
    public function userErrorHistoricalWeek($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalWeek($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por mes dividido en dias (month)
    public function userErrorHistoricalMonth($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalMonth($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por trimestre dividido en dias (quarter)
    public function userErrorHistoricalQuarter($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalQuarter($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por año dividido en dias (year)
    public function userErrorHistoricalYear($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalYear($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por total dividido en años (total)
    public function userErrorHistoricalTotal($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistoricalTotal($kingUserId)->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    // Historico del usuario por dia dividido en horas (today)
    public function userHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get(),
                    'error' => KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por semana dividido en dias (week)
    public function userHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por mes dividido en dias (month)
    public function userHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por trimestre dividido en dias (quarter)
    public function userHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por año dividido en dias (year)
    public function userHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get(),
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por total dividido en años (total)
    public function userHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::where('king_user_id', '=', $kingUserId)->count() +
                    KingMonitorError::where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones y errores del usuario
                'details' => [
                    'request' => KingMonitor::where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get(),
                    'error' => KingMonitorError::where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- HISTORICAL REQUEST ----------------------------------------------------------------
    // Historico de peticiones por dia dividido en horas (today)
    public function requestHistoricalToday() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalToday()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por semana dividido en dias (week)
    public function requestHistoricalWeek() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalWeek()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por mes dividido en dias (month)
    public function requestHistoricalMonth() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalMonth()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por trimestre dividido en dias (quarter)
    public function requestHistoricalQuarter() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalQuarter()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por año dividido en dias (year)
    public function requestHistoricalYear() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalYear()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por total dividido en años (total)
    public function requestHistoricalTotal() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistoricalTotal()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL ERROR ----------------------------------------------------------------
    // Historico de errores por dia dividido en horas (today)
    public function errorHistoricalToday() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalToday()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de errores por semana dividido en dias (week)
    public function errorHistoricalWeek() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalWeek()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de errores por mes dividido en dias (month)
    public function errorHistoricalMonth() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalMonth()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de errores por trimestre dividido en dias (quarter)
    public function errorHistoricalQuarter() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalQuarter()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de errores por año dividido en dias (year)
    public function errorHistoricalYear() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalYear()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de errores por total dividido en años (total)
    public function errorHistoricalTotal() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistoricalTotal()->original;

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    // Historico por dia dividido en horas (today)
    public function historicalToday() {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->count() +
                    KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de peticiones y errores
                'details' => [
                    'request' =>  KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get(),
                    'error' =>  KingMonitorError::whereDate('created_at', '=', date('Y-m-d'))->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por semana dividido en dias (week)
    public function historicalWeek() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(), // Total de peticiones y errores
                'details' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por mes dividido en dias (month)
    public function historicalMonth() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count() +
                    KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de peticiones y errores
                'details' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por trimestre dividido en dias (quarter)
    public function historicalQuarter() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count() +
                    KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(), // Total de peticiones y errores
                'details' => [
                    'request' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorError::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por año dividido en dias (year)
    public function historicalYear() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->count() +
                    KingMonitorError::whereYear('created_at', '=', now())->count(), // Total de errores
                'details' => [
                    'request' => KingMonitor::whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get(),
                    'error' => KingMonitorError::whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico por total dividido en años (total)
    public function historicalTotal() {
        try {
            $response = [
                'total' => KingMonitor::all()->count() + KingMonitorError::all()->count(), // Total de errores
                'details' => [
                    'request' => KingMonitor::select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get(),
                    'error' => KingMonitorError::select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get()
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function userRequestHistorical($kingUserId) {
        try {
            $king = new KingMonitorRequest();
            $response = $king->userRequestHistorical($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function userErrorHistorical($kingUserId) {
        try {
            $king = new KingMonitorError();
            $response = $king->userErrorHistorical($kingUserId)->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestHistorical() {
        try {
            $king = new KingMonitorRequest();
            $response = $king->requestHistorical()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function errorHistorical() {
        try {
            $king = new KingMonitorError();
            $response = $king->errorHistorical()->original;

            return response()->json($response);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function historical() {
        try {
            $response = [
                'request' => $this->requestHistorical()->original,
                'errors' => $this->errorHistorical()->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function userHistorical($kingUserId) {
        try {
            $response = [
                'request' => $this->userRequestHistorical($kingUserId)->original,
                'errors' => $this->userErrorHistorical($kingUserId)->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** AVG REQUEST ******************************************************************/
    public function averageRequestTimeToday() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeToday()->original;

        return response()->json($response);
    }

    public function averageRequestTimeWeek() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeWeek()->original;

        return response()->json($response);
    }

    public function averageRequestTimeMonth() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeMonth()->original;

        return response()->json($response);
    }

    public function averageRequestTimeQuarter() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeQuarter()->original;

        return response()->json($response);
    }

    public function averageRequestTimeYear() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeYear()->original;

        return response()->json($response);
    }

    public function averageRequestTimeTotal() {
        $king = new KingMonitorRequest();
        $response = $king->averageRequestTimeTotal()->original;

        return response()->json($response);
    }

    /****************************************************************** AVG ERROR ******************************************************************/
    public function averageErrorTimeToday() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeToday()->original;

        return response()->json($response);
    }

    public function averageErrorTimeWeek() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeWeek()->original;

        return response()->json($response);
    }

    public function averageErrorTimeMonth() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeMonth()->original;

        return response()->json($response);
    }

    public function averageErrorTimeQuarter() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeQuarter()->original;

        return response()->json($response);
    }

    public function averageErrorTimeYear() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeYear()->original;

        return response()->json($response);
    }

    public function averageErrorTimeTotal() {
        $king = new KingMonitorError();
        $response = $king->averageErrorTimeTotal()->original;

        return response()->json($response);
    }

    /****************************************************************** AVG ******************************************************************/
    public function averageTimeToday() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeToday()->original,
                'error' =>  $kingError->averageErrorTimeToday()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageTimeWeek() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeWeek()->original,
                'error' =>  $kingError->averageErrorTimeWeek()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageTimeMonth() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeMonth()->original,
                'error' =>  $kingError->averageErrorTimeMonth()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageTimeQuarter() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeQuarter()->original,
                'error' =>  $kingError->averageErrorTimeQuarter()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageTimeYear() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeYear()->original,
                'error' =>  $kingError->averageErrorTimeYear()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function averageTimeTotal() {
        try {
            $kingRequest = new KingMonitorRequest();
            $kingError = new KingMonitorError();

            $response = [
                'request' =>  $kingRequest->averageRequestTimeTotal()->original,
                'error' =>  $kingError->averageErrorTimeTotal()->original
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** MONITOR ******************************************************************/
    // Si hubo una alerta entonces obtener el dato de king_alert_user y si ya paso media hora y sigue superando el limite entonces volver a enviar otra alerta
    // Arreglar la parte de los destroy y crear un resource para poder obtener los datos
    public function monitor($response, $tuple = NULL, $withoutResource = FALSE) {
        try {
            // Guardar los datos en la base de datos
            $king_monitors = new KingMonitor();

            $king_monitors->king_user_id = (auth()->user() === NULL) ? NULL : auth()->user()->id;
            $king_monitors->tuple = $tuple;
            $king_monitors->method = request()->method();
            $king_monitors->endpoint = request()->path();
            $king_monitors->headers = (request()->header() === NULL) ? NULL : json_encode(Arr::except(request()->header(), ['authorization'])); // Mandamos los headers sin el authorization que es donde esta el token
            $king_monitors->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
            $king_monitors->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
            $king_monitors->params = (request()->input() === NULL || request()->input() === []) ? NULL : json_encode(request()->input()); // Crypt::encryptString(json_encode($request->input()));

            // Si la configuracion el resource esta en true o el parametro esta en true
            if (config('king-monitor.monitor.use_resource')) {
                if($withoutResource) { // Si no tiene resource
                    $king_monitors->code = ($response === NULL) ? NULL : $response->getStatusCode();
                } else {
                    $king_monitors->code = ($response === NULL) ? NULL : $response->toResponse(request())->getStatusCode();
                }
            } else {
                $king_monitors->code = ($response === NULL) ? NULL : $response->getStatusCode();
            }

            $king_monitors->response = ($response === NULL) ? NULL : json_encode($response); //Crypt::encryptString(json_encode($response));

            // Guardamos los datos en la bd
            $king_monitors->save();

            // Si el usuario supero el limite de peticiones
            if ($king_monitors->limit()) {
                // Si ya paso media hora desde la ultima alerta
                $king_monitor_alert = new KingMonitorAlert();

                // Guardamos el usuario que supero el limite de peticiones en KingMonitorUserExceeded
                $king_monitor_user_excededs = new KingMonitorUserExceeded();

                // Si el usuario no ha sido registrado en la tabla KingMonitorUserExceeded
                if(!$king_monitor_user_excededs->limit()) {
                    $king_monitor_user_excededs->type = 1; // request
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
                        $mailController->sendAlertLimit();

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
                            $mailController->sendAlertLimit();

                            // Guardamos la alerta
                            $king_monitor_alert->king_user_id = auth()->user()->id;
                            $king_monitor_alert->token = (request()->header() === NULL) ? NULL : request()->bearerToken();
                            $king_monitor_alert->ip = request()->getClientIp(); // Crypt::encryptString($request->getClientIp());
                            $king_monitor_alert->save();
                        }
                    }
                }
            }

            return $king_monitors;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    // Guardamos los errores en el monitor (Es lo mismo que el metodo monitor de KingMonitorError)
    public function monitorError($king_type_error_id, $error = NULL, $message = NULL) {
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
            $king_monitor_errors->code = ($error === NULL) ? 500 : ((!method_exists($error, 'getStatusCode')) ? 500 : $error->getStatusCode()); // Codigo HTTP
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
            if(!$king_monitor_user_excededs->limitError()) {
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
}
