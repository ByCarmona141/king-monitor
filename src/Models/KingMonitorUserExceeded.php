<?php

namespace ByCarmona141\KingMonitor\Models;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorUserExceeded extends Model {
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer'
    ];

    // Metodo para revisar si el usuario ya fue registrado en la tabla de KingMonitorUserExceeded
    public function limit(): bool {
        $result = false;

        $kingUserId = NULL;

        if(auth()->user() !== NULL) {
            $kingUserId = auth()->user()->id;
        }

        // Si el usuario y el token ya fue registrado en la tabla de KingMonitorUserExceeded
        if(KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('type', '=', 1)->where('king_user_id', '=', $kingUserId)->count() > 0 && KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('token', '=', request()->bearerToken())->count() > 0 && KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('ip', '=', request()->getClientIp())->count() > 0) {
            $result = true;
        }

        return $result;
    }

    // Metodo para revisar si el usuario ya fue registrado en la tabla de KingMonitorUserExceeded
    public function limitError(): bool {
        $result = false;

        $kingUserId = NULL;

        if(auth()->user() !== NULL) {
            $kingUserId = auth()->user()->id;
        }

        // Si el usuario y el token ya fue registrado en la tabla de KingMonitorUserExceeded
        if(KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('type', '=', 2)->where('king_user_id', '=', $kingUserId)->count() > 0 && KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('token', '=', request()->bearerToken())->count() > 0 && KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('ip', '=', request()->getClientIp())->count() > 0) {
            $result = true;
        }

        return $result;
    }

    /****************************************************************** USER ******************************************************************/
    // ---------------------------------------------------------------- USER EXCEEDED TODAY ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (today)
    public function userExceededToday() {
        return KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->distinct()->pluck('king_user_id');
    }

    // ---------------------------------------------------------------- USER EXCEEDED WEEK ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (week)
    public function userExceededWeek() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->distinct()->pluck('king_user_id');
    }

    // ---------------------------------------------------------------- USER EXCEEDED MONTH ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (month)
    public function userExceededMonth() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->distinct()->pluck('king_user_id');
    }

    // ---------------------------------------------------------------- USER EXCEEDED QUARTER ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (quarter)
    public function userExceededQuarter() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfQuarter(),
            Carbon::now()->endOfQuarter()
        ])->distinct()->pluck('king_user_id');
    }

    // ---------------------------------------------------------------- USER EXCEEDED YEAR ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (year)
    public function userExceededYear() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->distinct()->pluck('king_user_id');
    }

    // ---------------------------------------------------------------- USER EXCEEDED TOTAL ----------------------------------------------------------------
    // Obtenemos los usuarios que excedieron el limite de peticiones (total)
    public function userExceededTotal() {
        return KingMonitorUserExceeded::distinct()->pluck('king_user_id');
    }

    /****************************************************************** TOKEN ******************************************************************/
    // ---------------------------------------------------------------- TOKEN EXCEEDED TODAY ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (today)
    public function tokenExceededToday() {
        return KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->distinct()->pluck('token');
    }

    // ---------------------------------------------------------------- TOKEN EXCEEDED WEEK ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (week)
    public function tokenExceededWeek() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->distinct()->pluck('token');
    }

    // ---------------------------------------------------------------- TOKEN EXCEEDED MONTH ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (month)
    public function tokenExceededMonth() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->distinct()->pluck('token');
    }

    // ---------------------------------------------------------------- TOKEN EXCEEDED QUARTER ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (quarter)
    public function tokenExceededQuarter() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfQuarter(),
            Carbon::now()->endOfQuarter()
        ])->distinct()->pluck('token');
    }

    // ---------------------------------------------------------------- TOKEN EXCEEDED YEAR ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (year)
    public function tokenExceededYear() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->distinct()->pluck('token');
    }

    // ---------------------------------------------------------------- TOKEN EXCEEDED TOTAL ----------------------------------------------------------------
    // Obtenemos los tokens que excedieron el limite de peticiones (total)
    public function tokenExceededTotal() {
        return KingMonitorUserExceeded::distinct()->pluck('token');
    }

    /****************************************************************** IP ******************************************************************/
    // ---------------------------------------------------------------- IP EXCEEDED TODAY ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (today)
    public function ipExceededToday() {
        return KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->distinct()->pluck('ip');
    }

    // ---------------------------------------------------------------- IP EXCEEDED WEEK ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (week)
    public function ipExceededWeek() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->distinct()->pluck('ip');
    }

    // ---------------------------------------------------------------- IP EXCEEDED MONTH ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (month)
    public function ipExceededMonth() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->distinct()->pluck('ip');
    }

    // ---------------------------------------------------------------- IP EXCEEDED QUARTER ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (quarter)
    public function ipExceededQuarter() {
        return KingMonitorUserExceeded::whereBetween('created_at', [
            Carbon::now()->startOfQuarter(),
            Carbon::now()->endOfQuarter()
        ])->distinct()->pluck('ip');
    }

    // ---------------------------------------------------------------- IP EXCEEDED YEAR ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (year)
    public function ipExceededYear() {
        return KingMonitorUserExceeded::whereYear('created_at', '=', now())->distinct()->pluck('ip');
    }

    // ---------------------------------------------------------------- IP EXCEEDED TOTAL ----------------------------------------------------------------
    // Obtenemos las IP que excedieron el limite de peticiones (total)
    public function ipExceededTotal() {
        return KingMonitorUserExceeded::distinct()->pluck('ip');
    }

    /****************************************************************** STATISTICS ******************************************************************/
    /****************************************************************** USER STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- USER STATISTICS REQUEST ----------------------------------------------------------------
    // Estadisticas de peticiones del usuario (today)
    public function userRequestStatisticsToday($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones del usuario (week)
    public function userRequestStatisticsWeek($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones del usuario (month)
    public function userRequestStatisticsMonth($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones del usuario (quarter)
    public function userRequestStatisticsQuarter($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones del usuario (year)
    public function userRequestStatisticsYear($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones del usuario (total)
    public function userRequestStatisticsTotal($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- USER STATISTICS ERROR ----------------------------------------------------------------
    // Estadisticas de errores del usuario (today)
    public function userErrorStatisticsToday($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores del usuario (week)
    public function userErrorStatisticsWeek($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores del usuario (month)
    public function userErrorStatisticsMonth($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores del usuario (quarter)
    public function userErrorStatisticsQuarter($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores del usuario (year)
    public function userErrorStatisticsYear($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores del usuario (total)
    public function userErrorStatisticsTotal($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- USER STATISTICS ----------------------------------------------------------------
    // Estadisticas del usuario (today)
    public function userStatisticsToday($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas del usuario (week)
    public function userStatisticsWeek($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas del usuario (month)
    public function userStatisticsMonth($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas del usuario (quarter)
    public function userStatisticsQuarter($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas del usuario (year)
    public function userStatisticsYear($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas del usuario (total)
    public function userStatisticsTotal($kingUserId) {
        $response = [
            'total' => KingMonitorUserExceeded::where('king_user_id', '=', $kingUserId)->count(), // Cantidad de usuarios que excedieron el limite
            'ip' => KingMonitorUserExceeded::where('king_user_id', '=', $kingUserId)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- STATISTICS USER ----------------------------------------------------------------
    // Estadisticas de peticiones
    public function userRequestStatistics($kingUserId) {
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
    }

    // Estadisticas de errores
    public function userErrorStatistics($kingUserId) {
        $today = $this->userErrorStatisticsToday($kingUserId);
        $week = $this->userErrorStatisticsWeek($kingUserId);
        $month = $this->userErrorStatisticsMonth($kingUserId);
        $quarter = $this->userErrorStatisticsQuarter($kingUserId);
        $year = $this->userErrorStatisticsYear($kingUserId);
        $total = $this->userErrorStatisticsTotal($kingUserId);

        $response = [
            'today' => $today->original,
            'week' => $week->original,
            'month' => $month->original,
            'quarter' => $quarter->original,
            'year' => $year->original,
            'total' => $total->original,
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones y errores
    public function userStatistics($kingUserId) {
        $response = [
            'request' => $this->userRequestStatistics($kingUserId)->original,
            'errors' => $this->userErrorStatistics($kingUserId)->original,
        ];

        return response()->json($response);
    }

    /****************************************************************** STATISTICS ******************************************************************/
    // ---------------------------------------------------------------- REQUEST STATISTICS ----------------------------------------------------------------
    // Estadisticas de peticiones (today)
    public function requestStatisticsToday() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones (week)
    public function requestStatisticsWeek() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones (month)
    public function requestStatisticsMonth() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones (quarter)
    public function requestStatisticsQuarter() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones (year)
    public function requestStatisticsYear() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones (total)
    public function requestStatisticsTotal() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 1)->count(), // Cantidad de usuarios que excedieron el limite de peticiones
            'user' => KingMonitorUserExceeded::where('type', '=', 1)->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos de peticiones
            'ip' => KingMonitorUserExceeded::where('type', '=', 1)->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos de peticiones
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- ERROR STATISTICS ----------------------------------------------------------------
    // Estadisticas de errores (today)
    public function errorStatisticsToday() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores (week)
    public function errorStatisticsWeek() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores (month)
    public function errorStatisticsMonth() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores (quarter)
    public function errorStatisticsQuarter() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores (year)
    public function errorStatisticsYear() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas de errores (total)
    public function errorStatisticsTotal() {
        $response = [
            'total' => KingMonitorUserExceeded::where('type', '=', 2)->count(), // Cantidad de usuarios que excedieron el limite de errores
            'user' => KingMonitorUserExceeded::where('type', '=', 2)->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos de errores
            'ip' => KingMonitorUserExceeded::where('type', '=', 2)->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos de errores
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    // Estadisticas (today)
    public function statisticsToday() {
        $response = [
            'total' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas (week)
    public function statisticsWeek() {
        $response = [
            'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas (month)
    public function statisticsMonth() {
        $response = [
            'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas (quarter)
    public function statisticsQuarter() {
        $response = [
            'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::whereBetween('created_at', [
                Carbon::now()->startOfQuarter(),
                Carbon::now()->endOfQuarter()
            ])->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas (year)
    public function statisticsYear() {
        $response = [
            'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // Estadisticas (total)
    public function statisticsTotal() {
        $response = [
            'total' => KingMonitorUserExceeded::all()->count(), // Cantidad de usuarios que excedieron el limite
            'user' => KingMonitorUserExceeded::all()->where('king_user_id', '!=', NULL)->pluck('king_user_id')->mode(), // Usuario con la mayor cantidad de excesos
            'ip' => KingMonitorUserExceeded::all()->where('ip', '!=', NULL)->pluck('ip')->mode(), // IP del usuario con la mayor cantidad de excesos
        ];

        return response()->json($response);
    }

    // ---------------------------------------------------------------- STATISTICS ----------------------------------------------------------------
    // Estadisticas de peticiones
    public function requestStatistics() {
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
    }

    // Estadisticas de errores
    public function errorStatistics() {
        $today = $this->errorStatisticsToday();
        $week = $this->errorStatisticsWeek();
        $month = $this->errorStatisticsMonth();
        $quarter = $this->errorStatisticsQuarter();
        $year = $this->errorStatisticsYear();
        $total = $this->errorStatisticsTotal();

        $response = [
            'today' => $today->original,
            'week' => $week->original,
            'month' => $month->original,
            'quarter' => $quarter->original,
            'year' => $year->original,
            'total' => $total->original,
        ];

        return response()->json($response);
    }

    // Estadisticas de peticiones y errores
    public function statistics() {
        $response = [
            'request' => $this->requestStatistics()->original,
            'errors' => $this->errorStatistics()->original,
        ];

        return response()->json($response);
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    /****************************************************************** USER HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- USER REQUEST HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones del usuario (today)
    public function userRequestHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (week)
    public function userRequestHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (month)
    public function userRequestHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (quarter)
    public function userRequestHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (year)
    public function userRequestHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (total)
    public function userRequestHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->all()->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER ERROR HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones del usuario (today)
    public function userErrorHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (week)
    public function userErrorHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (month)
    public function userErrorHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (quarter)
    public function userErrorHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (year)
    public function userErrorHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (total)
    public function userErrorHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->all()->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- USER HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones del usuario (today)
    public function userHistoricalToday($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (week)
    public function userHistoricalWeek($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (month)
    public function userHistoricalMonth($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (quarter)
    public function userHistoricalQuarter($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->where('king_user_id', '=', $kingUserId)->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->where('king_user_id', '=', $kingUserId)->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (year)
    public function userHistoricalYear($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones del usuario (total)
    public function userHistoricalTotal($kingUserId) {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::all()->count(), // Total de peticiones del usuario
                'details' => [
                    'request' => KingMonitorUserExceeded::where('type', '=', 1)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get(),
                    'error' => KingMonitorUserExceeded::where('type', '=', 2)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /****************************************************************** HISTORICAL ******************************************************************/
    // ---------------------------------------------------------------- REQUEST HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones por dia dividido en horas (today)
    public function requestHistoricalToday() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por semana dividido en dias (week)
    public function requestHistoricalWeek() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por mes dividido en dias (month)
    public function requestHistoricalMonth() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por trimestre dividido en dias (quarter)
    public function requestHistoricalQuarter() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por año dividido en dias (year)
    public function requestHistoricalYear() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por total dividido en años (total)
    public function requestHistoricalTotal() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 1)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 1)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- ERROR HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones por dia dividido en horas (today)
    public function errorHistoricalToday() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->select(
                    DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                    DB::raw('count(*) as total')
                )->groupBy('hour')->orderBy('hour')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por semana dividido en dias (week)
    public function errorHistoricalWeek() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get(),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por mes dividido en dias (month)
    public function errorHistoricalMonth() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por trimestre dividido en dias (quarter)
    public function errorHistoricalQuarter() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Total de peticiones
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->select(
                    DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                    DB::raw('count(*) as total')
                )->groupBy('day')->orderBy('day')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por año dividido en dias (year)
    public function errorHistoricalYear() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->select(
                    DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                    DB::raw('count(*) as total')
                )->groupBy('month')->orderBy('month')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por total dividido en años (total)
    public function errorHistoricalTotal() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::where('type', '=', 2)->count(), // Total de peticiones del usuario
                'details' => KingMonitorUserExceeded::where('type', '=', 2)->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('count(*) as total')
                )->groupBy('year')->orderBy('year')->get()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------------------------------------------------------------- HISTORICAL ----------------------------------------------------------------
    // Historico de peticiones por dia dividido en horas (today)
    public function historicalToday() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereDate('created_at', '=', date('Y-m-d'))->count(), // Total de peticiones
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->whereDate('created_at', '=', date('Y-m-d'))->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->whereDate('created_at', '=', date('Y-m-d'))->select(
                        DB::raw('DATE_FORMAT(created_at, "%H") as hour'),
                        DB::raw('count(*) as total')
                    )->groupBy('hour')->orderBy('hour')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por semana dividido en dias (week)
    public function historicalWeek() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(), // Total de peticiones
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por mes dividido en dias (month)
    public function historicalMonth() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->count(), // Total de peticiones
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->whereMonth('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por trimestre dividido en dias (quarter)
    public function historicalQuarter() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereBetween('created_at', [
                    Carbon::now()->startOfQuarter(),
                    Carbon::now()->endOfQuarter()
                ])->count(), // Total de peticiones
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->whereBetween('created_at', [
                        Carbon::now()->startOfQuarter(),
                        Carbon::now()->endOfQuarter()
                    ])->select(
                        DB::raw('DATE_FORMAT(created_at, "%d") as day'),
                        DB::raw('count(*) as total')
                    )->groupBy('day')->orderBy('day')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por año dividido en dias (year)
    public function historicalYear() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::whereYear('created_at', '=', now())->count(), // Total de peticiones del usuario
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->whereYear('created_at', '=', now())->select(
                        DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                        DB::raw('count(*) as total')
                    )->groupBy('month')->orderBy('month')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Historico de peticiones por total dividido en años (total)
    public function historicalTotal() {
        try {
            $response = [
                'total' => KingMonitorUserExceeded::all()->count(), // Total de peticiones del usuario
                'details' => [
                    'request' =>  KingMonitorUserExceeded::where('type', '=', 1)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get(),
                    'error' =>  KingMonitorUserExceeded::where('type', '=', 2)->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                        DB::raw('count(*) as total')
                    )->groupBy('year')->orderBy('year')->get()
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userErrorHistorical($kingUserId) {
        try {
            $today = $this->userErrorHistoricalToday($kingUserId);
            $week = $this->userErrorHistoricalWeek($kingUserId);
            $month = $this->userErrorHistoricalMonth($kingUserId);
            $quarter = $this->userErrorHistoricalQuarter($kingUserId);
            $year = $this->userErrorHistoricalYear($kingUserId);
            $total = $this->userErrorHistoricalTotal($kingUserId);

            $response = [
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
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
                'today' => $today->original,
                'week' => $week->original,
                'month' => $month->original,
                'quarter' => $quarter->original,
                'year' => $year->original,
                'total' => $total->original,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
