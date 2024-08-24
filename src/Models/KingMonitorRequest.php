<?php

namespace ByCarmona141\KingMonitor\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorRequest extends Model {
    use HasFactory;

    protected $table = 'king_monitors';

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

    /****************************************************************** STATISTICS ******************************************************************/
    /****************************************************************** USER REQUEST STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST STATISTICS TODAY ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (today)
    public function userRequestStatisticsToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de hoy del usuario
                //'lastMinute' => KingMonitor::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de peticiones en la ultima hora
                'method' => [ // Cantidad de peticiones en metodos del dia
                    'mostCommon' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones del dia del usuario
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (today)
    public function userRequestMethodStatisticsToday($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS WEEK ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (week)
    public function userRequestStatisticsWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones de la semana
                //'lastDayWeek' => KingMonitor::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de peticiones en el ultimo dia de la semana
                'method' => [ // Total de peticiones en metodos de la semana
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
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
    public function userRequestMethodStatisticsWeek($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS MONTH ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (month)
    public function userRequestStatisticsMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                //'lastWeekMonth' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de peticiones de la ultima semana del mes
                'method' => [ // Total de peticiones en metodos del mes
                    'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (month)
    public function userRequestMethodStatisticsMonth($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS QUARTER ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (quarter)
    public function userRequestStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                //'lastMonthQuarter' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfQuarter()->subMonth(2),
                //    Carbon::now()->endOfQuarter()
                //])->count(), // Cantidad de peticiones del ultimo mes del trimestre
                'method' => [ // Total de peticiones en metodos del trimestre
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
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
    public function userRequestMethodStatisticsQuarter($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS YEAR ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (year)
    public function userRequestStatisticsYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'method' => [ // Cantidad de peticiones a metodos del año
                    'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (year)
    public function userRequestMethodStatisticsYear($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS REQUEST USERS TOTAL ----------------------------------------------------------------
    // Estadisticas de peticiones de un usuario (total)
    public function userRequestStatisticsTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::where('king_user_id', '=', $kingUserId)->count(), // Cantidad de peticiones en total
                'method' => [
                    'mostCommon' => KingMonitor::where('king_user_id', '=', $kingUserId)->pluck('method')->mode(), // Metodo con la mayor cantidad de peticiones
                    'GET' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                    'POST' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
                ]
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP de un usuario (total)
    public function userRequestMethodStatisticsTotal($kingUserId) {
        try {
            $response = [
                'GET' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'GET')->count(),
                'POST' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'POST')->count(),
                'PUT' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitor::where('king_user_id', '=', $kingUserId)->where('method', '=', 'DELETE')->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS REQUEST ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS TODAY REQUEST ----------------------------------------------------------------
    // Estadisticas de peticiones (today)
    public function requestStatisticsToday() {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->count(),
                //'lastMinute' => KingMonitor::where('created_at', '>=', Carbon::now()->subHour())->count(), // Cantidad de peticiones en la ultima hora
                'method' => [
                    'mostCommon' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                ],
                'user' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (today)
    public function requestMethodStatisticsToday() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereDate('created_at', '=', date('Y-m-d'))->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereDate('created_at', '=', date('Y-m-d'))->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (today)
    public function requestStatisticsFrequentUserToday() {
        try {
            $response = [
                'user' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS WEEK REQUEST ----------------------------------------------------------------
    // Estadisticas de peticiones (week)
    public function requestStatisticsWeek() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                //'lastDayWeek' => KingMonitor::where('created_at', '=', Carbon::now()->endOfWeek())->count(), // Cantidad de peticiones en el ultimo dia de la semana
                'method' => [ // Total de peticiones en metodos de la semana
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->count(),
                ],
                'user' =>  KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestMethodStatisticsWeek() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestStatisticsFrequentUserWeek() {
        try {
            $response = [
                'user' =>  KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS MONTH REQUEST ----------------------------------------------------------------
    // Estadisticas de peticiones (month)
    public function requestStatisticsMonth() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                //'lastWeekMonth' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfMonth()->subDays(6),
                //    Carbon::now()->endOfMonth()
                //])->count(), // Cantidad de peticiones de la ultima semana del mes
                'method' => [
                    'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                ],
                'user' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de peticiones del mes
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (month)
    public function requestMethodStatisticsMonth() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (month)
    public function requestStatisticsFrequentUserMonth() {
        try {
            $response = [
                'user' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- STATISTICS QUARTER REQUEST ----------------------------------------------------------------
    // Estadisticas de peticiones (quarter)
    public function requestStatisticsQuarter() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                //'lastMonthQuarter' => KingMonitor::whereBetween('created_at', [
                //    Carbon::now()->endOfQuarter()->subMonth(2),
                //    Carbon::now()->endOfQuarter()
                //])->count(), // Cantidad de peticiones del ultimo mes del trimestre
                'method' => [
                    'mostCommon' => KingMonitor::whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->count(),
                ],
                'user' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (quarter)
    public function requestMethodStatisticsQuarter() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (quarter)
    public function requestStatisticsFrequentUserQuarter() {
        try {
            $response = [
                'user' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS YEAR ----------------------------------------------------------------
    // Estadisticas de peticiones (year)
    public function requestStatisticsYear() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->count(),
                'method' => [
                    'mostCommon' => KingMonitor::whereYear('created_at', '=', now())->pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
                ],
                'user' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (year)
    public function requestMethodStatisticsYear() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->whereYear('created_at', '=', now())->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->whereYear('created_at', '=', now())->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->whereYear('created_at', '=', now())->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->whereYear('created_at', '=', now())->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->whereYear('created_at', '=', now())->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (year)
    public function requestStatisticsFrequentUserYear() {
        try {
            $response = [
                'user' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- REQUEST STATISTICS TOTAL ----------------------------------------------------------------
    // Estadisticas de peticiones (total)
    public function requestStatisticsTotal() {
        try {
            $response = [
                'total' => KingMonitor::all()->count(),
                'method' => [
                    'mostCommon' => KingMonitor::pluck('method')->mode(),
                    'GET' => KingMonitor::where('method', '=', 'GET')->count(),
                    'POST' => KingMonitor::where('method', '=', 'POST')->count(),
                    'PUT' => KingMonitor::where('method', '=', 'PUT')->count(),
                    'PATCH' => KingMonitor::where('method', '=', 'PATCH')->count(),
                    'DELETE' => KingMonitor::where('method', '=', 'DELETE')->count(),
                ],
                'user' => KingMonitor::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Estadisticas de los metodos HTTP (total)
    public function requestMethodStatisticsTotal() {
        try {
            $response = [
                'GET' => KingMonitor::where('method', '=', 'GET')->count(),
                'POST' => KingMonitor::where('method', '=', 'POST')->count(),
                'PUT' => KingMonitor::where('method', '=', 'PUT')->count(),
                'PATCH' => KingMonitor::where('method', '=', 'PATCH')->count(),
                'DELETE' => KingMonitor::where('method', '=', 'DELETE')->count(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Usuario con la mayor cantidad de peticiones (total)
    public function requestStatisticsFrequentUserTotal() {
        try {
            $response = [
                'user' => KingMonitor::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ******************************************************************/
    public function userRequestStatistics($kingUserId) {
        try {
            $today = $this->userRequestStatisticsToday($kingUserId);
            $week = $this->userRequestStatisticsWeek($kingUserId);
            $month = $this->userRequestStatisticsMonth($kingUserId);
            $quarter = $this->userRequestStatisticsQuarter($kingUserId);
            $year = $this->userRequestStatisticsYear($kingUserId);
            $total = $this->userRequestStatisticsTotal($kingUserId);

            $response = [
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestStatistics() {
        try {
            $today = $this->requestStatisticsToday();
            $week = $this->requestStatisticsWeek();
            $month = $this->requestStatisticsMonth();
            $quarter = $this->requestStatisticsQuarter();
            $year = $this->requestStatisticsYear();
            $total = $this->requestStatisticsTotal();

            $response = [
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** STATISTICS ENDPOINTS ******************************************************************/
    // ---------------------------------------------------------------- STATISTICS ENDPOINTS ----------------------------------------------------------------
    // Obtener los endpoints con mayor cantidad de peticiones y errores (aun hace falta)
    public function requestStatisticsEndpointTotal() {
        try {
            $response = [];

            // Route::getRoutes()
            foreach (config('king-monitor.monitor.endpoint_statistics') as $endpoint) {
                // Arreglo con la cantidad de peticiones del dia
                $response[] = [
                    'name' => $endpoint,
                    'total' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->count(),
                    'method' => [ // Total de metodos ocupados de hoy
                        'GET' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'GET')->count(),
                        'POST' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'POST')->count(),
                        'PUT' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'PUT')->count(),
                        'PATCH' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'PATCH')->count(),
                        'DELETE' => KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('method', '=', 'DELETE')->count(),
                    ],
                    'user' =>  KingMonitor::where('endpoint', 'like', $endpoint . '%')->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de peticiones
                ];
            }

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER HISTORICAL REQUEST ----------------------------------------------------------------
    // Historico del usuario por dia dividido en horas (today)
    public function userRequestHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por semana dividido en dias (week)
    public function userRequestHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por mes dividido en dias (month)
    public function userRequestHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por trimestre dividido en dias (quarter)
    public function userRequestHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por año dividido en dias (year)
    public function userRequestHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico del usuario por total dividido en años (total)
    public function userRequestHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitor::where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitor::where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
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
            $response = [
                'total' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de peticiones
                'details' => KingMonitor::whereDate('created_at', '=', date('Y-m-d'))->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por semana dividido en dias (week)
    public function requestHistoricalWeek() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Total de peticiones
                'details' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por mes dividido en dias (month)
    public function requestHistoricalMonth() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de peticiones
                'details' => KingMonitor::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por trimestre dividido en dias (quarter)
    public function requestHistoricalQuarter() {
        try {
            $response = [
                'total' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Total de peticiones
                'details' => KingMonitor::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por año dividido en dias (year)
    public function requestHistoricalYear() {
        try {
            $response = [
                'total' => KingMonitor::whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => KingMonitor::whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por total dividido en años (total)
    public function requestHistoricalTotal() {
        try {
            $response = [
                'total' => KingMonitor::all()->count(), // Total de peticiones del usuario
                'details' => KingMonitor::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    public function userRequestHistorical($kingUserId) {
        try {
            $today = $this->userRequestHistoricalToday($kingUserId);
            $week = $this->userRequestHistoricalWeek($kingUserId);
            $month = $this->userRequestHistoricalMonth($kingUserId);
            $quarter = $this->userRequestHistoricalQuarter($kingUserId);
            $year = $this->userRequestHistoricalYear($kingUserId);
            $total = $this->userRequestHistoricalTotal($kingUserId);

            $response = [
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestHistorical() {
        try {
            $today = $this->requestHistoricalToday();
            $week = $this->requestHistoricalWeek();
            $month = $this->requestHistoricalMonth();
            $quarter = $this->requestHistoricalQuarter();
            $year = $this->requestHistoricalYear();
            $total = $this->requestHistoricalTotal();

            $response = [
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
