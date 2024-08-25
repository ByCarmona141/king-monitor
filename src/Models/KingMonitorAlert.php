<?php

namespace ByCarmona141\KingMonitor\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorAlert extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'king_user_id',
        'token',
        'ip',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
    ];

    // Obtenemos la ultima alerta del dia del usuario
    public function lastAlertToday() {
        try {
            return kingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', auth()->user()->id)->latest()->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Alertas del día, si no se manda el dia se obtienen las alertas del día
//    public function kingDay(Request $request): KingMonitorAlertCollection {
//        $response = NULL;
//
//        if ($request->data['attributes']['day'] === NULL) {
//            $response = KingMonitorAlertCollection::make(KingMonitorAlert::whereDate('created_at', '=', today())->get());
//        } else {
//            $response = KingMonitorAlertCollection::make(KingMonitorAlert::whereDate('created_at', '=', $request->data['attributes']['day'])->get());
//        }
//
//        // Guardamos la accion en el monitor
//        $kingMonitor = new KingMonitor();
//        $kingMonitor->monitor($response);
//
//        return $response;
//    }

    /****************************************************************** USER STATISTICS ******************************************************************/
    // Estadisticas de alertas del usuario (today)
    public function userStatisticsToday($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    // Estadisticas de alertas del usuario (week)
    public function userStatisticsWeek($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    // Estadisticas de alertas del usuario (month)
    public function userStatisticsMonth($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    // Estadisticas de alertas del usuario (quarter)
    public function userStatisticsQuarter($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    // Estadisticas de alertas del usuario (year)
    public function userStatisticsYear($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    // Estadisticas de alertas del usuario (total)
    public function userStatisticsTotal($kingUserId) {
        $response = [
            'total' => KingMonitorAlert::where('king_user_id', '=', $kingUserId)->count(), // Cantidad de alertas del usuario
            'ip' => KingMonitorAlert::where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
        ];

        return response()->json($response);
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // Total de alertas (today)
    public function statisticsToday() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->count(),
                'user' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de alertas
                'ip' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (week)
    public function statisticsWeek() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'user' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de alertas
                'ip' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (month)
    public function statisticsMonth() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'user' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de alertas
                'ip' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (quarter)
    public function statisticsQuarter() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'user' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de alertas
                'ip' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (year)
    public function statisticsYear() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->count(),
                'user' => KingMonitorAlert::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de alertas
                'ip' => KingMonitorAlert::whereYear('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (total)
    public function statisticsTotal() {
        try {
            $response = [
                'total' => KingMonitorAlert::all()->count(),
                'user' => KingMonitorAlert::where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos de alertas
                'ip' => KingMonitorAlert::where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos de alertas
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** USER HISTORICAL ******************************************************************/
    // Historico de alertas del usuario (today)
    public function userHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (week)
    public function userHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::whereBetween('created_at', [
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

    // Historico de alertas del usuario (month)
    public function userHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (quarter)
    public function userHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
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

    // Historico de alertas del usuario (year)
    public function userHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de alertas del usuario (total)
    public function userHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorAlert::all()->count(), // Total de alertas del usuario
                'details' => KingMonitorAlert::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get(),
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // Total de alertas (today)
    public function historicalToday() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->count(),
                'details' => KingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (week)
    public function historicalWeek() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'details' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
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

    // Total de alertas (month)
    public function historicalMonth() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(),
                'details' => KingMonitorAlert::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (quarter)
    public function historicalQuarter() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(),
                'details' => KingMonitorAlert::whereBetween('created_at', [
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

    // Total de alertas (year)
    public function historicalYear() {
        try {
            $response = [
                'total' => KingMonitorAlert::whereYear('created_at', '=', now())->count(),
                'details' => KingMonitorAlert::whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Total de alertas (total)
    public function historicalTotal() {
        try {
            $response = [
                'total' => KingMonitorAlert::all()->count(),
                'details' => KingMonitorAlert::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

