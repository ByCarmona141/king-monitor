<?php

namespace ByCarmona141\KingMonitor\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorRequest extends Model
{
    use HasFactory;

    protected $table = 'king_monitors';

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
    ];

    protected $casts = [
        'id'           => 'integer',
        'king_user_id' => 'integer',
    ];

    /****************************************************************** QUERY SCOPES ******************************************************************/

    public function scopeForPeriod(Builder $query, string $period): Builder
    {
        return match ($period) {
            'today'   => $query->whereDate('created_at', today()),
            'week'    => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'month'   => $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month),
            'quarter' => $query->whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]),
            'year'    => $query->whereYear('created_at', now()->year),
            default   => $query, // total
        };
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('king_user_id', $userId);
    }

    public function scopeOfMethod(Builder $query, string $method): Builder
    {
        return $query->where('method', $method);
    }

    /****************************************************************** PRIVATE HELPERS ******************************************************************/

    private function buildMethodBreakdown(string $period, ?int $userId = null): array
    {
        $query = fn(string $method) => $this->baseQuery($period, $userId)->ofMethod($method)->count();

        return [
            'mostCommon' => $this->baseQuery($period, $userId)->pluck('method')->mode(),
            'GET'        => $query('GET'),
            'POST'       => $query('POST'),
            'PUT'        => $query('PUT'),
            'PATCH'      => $query('PATCH'),
            'DELETE'     => $query('DELETE'),
        ];
    }

    private function buildStatistics(string $period, ?int $userId = null): array
    {
        $base = $this->baseQuery($period, $userId);

        return [
            'total'  => $base->count(),
            'method' => $this->buildMethodBreakdown($period, $userId),
            'user'   => $userId
                ? null
                : self::forPeriod($period)->whereNotNull('king_user_id')->pluck('king_user_id')->mode(),
        ];
    }

    private function buildFrequentUser(string $period): array
    {
        return [
            'user' => self::forPeriod($period)
                ->whereNotNull('king_user_id')
                ->pluck('king_user_id')
                ->mode(),
        ];
    }

    private function buildHistorical(string $period, ?int $userId = null): array
    {
        $alias  = $this->aliasForPeriod($period);
        $format = $this->groupFormatForPeriod($period);

        return [
            'total'   => $this->baseQuery($period, $userId)->count(),
            'details' => $this->baseQuery($period, $userId)
                ->select(
                    DB::raw("DATE_FORMAT(created_at, '{$format}') as {$alias}"),
                    DB::raw('count(*) as total')
                )
                ->groupBy($alias)
                ->orderBy($alias)
                ->get(),
        ];
    }

    private function buildAverageTime(string $period): array
    {
        $records = self::forPeriod($period)->orderBy('created_at')->get();

        if ($records->count() < 2) {
            return ['min' => null, 'avg' => null, 'max' => null];
        }

        $intervals = $records->zip($records->slice(1))->map(
            fn($pair) => $pair[1]->created_at->diffInSeconds($pair[0]->created_at)
        );

        return [
            'min' => $intervals->min(),
            'avg' => $intervals->average(),
            'max' => $intervals->max(),
        ];
    }

    private function buildAllPeriods(callable $builder): array
    {
        return [
            'today'   => $builder('today'),
            'week'    => $builder('week'),
            'month'   => $builder('month'),
            'quarter' => $builder('quarter'),
            'year'    => $builder('year'),
            'total'   => $builder('total'),
        ];
    }

    private function baseQuery(string $period, ?int $userId = null): Builder
    {
        $query = self::forPeriod($period);

        return $userId ? $query->forUser($userId) : $query;
    }

    private function groupFormatForPeriod(string $period): string
    {
        return match ($period) {
            'today'                    => '%H',
            'week', 'month', 'quarter' => '%d',
            'year'                     => '%M',
            default                    => '%Y',
        };
    }

    private function aliasForPeriod(string $period): string
    {
        return match ($period) {
            'today'                    => 'hour',
            'week', 'month', 'quarter' => 'day',
            'year'                     => 'month',
            default                    => 'year',
        };
    }

    /****************************************************************** USER STATISTICS ******************************************************************/

    public function userRequestStatisticsToday(int $userId): array   { return $this->buildStatistics('today',   $userId); }
    public function userRequestStatisticsWeek(int $userId): array    { return $this->buildStatistics('week',    $userId); }
    public function userRequestStatisticsMonth(int $userId): array   { return $this->buildStatistics('month',   $userId); }
    public function userRequestStatisticsQuarter(int $userId): array { return $this->buildStatistics('quarter', $userId); }
    public function userRequestStatisticsYear(int $userId): array    { return $this->buildStatistics('year',    $userId); }
    public function userRequestStatisticsTotal(int $userId): array   { return $this->buildStatistics('total',   $userId); }

    public function userRequestMethodStatisticsToday(int $userId): array   { return $this->buildMethodBreakdown('today',   $userId); }
    public function userRequestMethodStatisticsWeek(int $userId): array    { return $this->buildMethodBreakdown('week',    $userId); }
    public function userRequestMethodStatisticsMonth(int $userId): array   { return $this->buildMethodBreakdown('month',   $userId); }
    public function userRequestMethodStatisticsQuarter(int $userId): array { return $this->buildMethodBreakdown('quarter', $userId); }
    public function userRequestMethodStatisticsYear(int $userId): array    { return $this->buildMethodBreakdown('year',    $userId); }
    public function userRequestMethodStatisticsTotal(int $userId): array   { return $this->buildMethodBreakdown('total',   $userId); }

    /****************************************************************** STATISTICS ******************************************************************/

    public function requestStatisticsToday(): array   { return $this->buildStatistics('today'); }
    public function requestStatisticsWeek(): array    { return $this->buildStatistics('week'); }
    public function requestStatisticsMonth(): array   { return $this->buildStatistics('month'); }
    public function requestStatisticsQuarter(): array { return $this->buildStatistics('quarter'); }
    public function requestStatisticsYear(): array    { return $this->buildStatistics('year'); }
    public function requestStatisticsTotal(): array   { return $this->buildStatistics('total'); }

    public function requestMethodStatisticsToday(): array   { return $this->buildMethodBreakdown('today'); }
    public function requestMethodStatisticsWeek(): array    { return $this->buildMethodBreakdown('week'); }
    public function requestMethodStatisticsMonth(): array   { return $this->buildMethodBreakdown('month'); }
    public function requestMethodStatisticsQuarter(): array { return $this->buildMethodBreakdown('quarter'); }
    public function requestMethodStatisticsYear(): array    { return $this->buildMethodBreakdown('year'); }
    public function requestMethodStatisticsTotal(): array   { return $this->buildMethodBreakdown('total'); }

    public function requestStatisticsFrequentUserToday(): array   { return $this->buildFrequentUser('today'); }
    public function requestStatisticsFrequentUserWeek(): array    { return $this->buildFrequentUser('week'); }
    public function requestStatisticsFrequentUserMonth(): array   { return $this->buildFrequentUser('month'); }
    public function requestStatisticsFrequentUserQuarter(): array { return $this->buildFrequentUser('quarter'); }
    public function requestStatisticsFrequentUserYear(): array    { return $this->buildFrequentUser('year'); }
    public function requestStatisticsFrequentUserTotal(): array   { return $this->buildFrequentUser('total'); }

    /****************************************************************** AGGREGATE STATISTICS ******************************************************************/

    public function userRequestStatistics(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildStatistics($p, $userId));
    }

    public function requestStatistics(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildStatistics($p));
    }

    /****************************************************************** ENDPOINT STATISTICS ******************************************************************/

    public function requestStatisticsEndpointTotal(): array
    {
        return collect(config('king-monitor.monitor.endpoint_statistics'))
            ->map(fn(string $endpoint) => [
                'name'   => $endpoint,
                'total'  => self::where('endpoint', 'like', "{$endpoint}%")->count(),
                'method' => [
                    'GET'    => self::where('endpoint', 'like', "{$endpoint}%")->ofMethod('GET')->count(),
                    'POST'   => self::where('endpoint', 'like', "{$endpoint}%")->ofMethod('POST')->count(),
                    'PUT'    => self::where('endpoint', 'like', "{$endpoint}%")->ofMethod('PUT')->count(),
                    'PATCH'  => self::where('endpoint', 'like', "{$endpoint}%")->ofMethod('PATCH')->count(),
                    'DELETE' => self::where('endpoint', 'like', "{$endpoint}%")->ofMethod('DELETE')->count(),
                ],
                'user' => self::where('endpoint', 'like', "{$endpoint}%")
                    ->whereNotNull('king_user_id')
                    ->pluck('king_user_id')
                    ->mode(),
            ])
            ->values()
            ->toArray();
    }

    /****************************************************************** USER HISTORICAL ******************************************************************/

    public function userRequestHistoricalToday(int $userId): array   { return $this->buildHistorical('today',   $userId); }
    public function userRequestHistoricalWeek(int $userId): array    { return $this->buildHistorical('week',    $userId); }
    public function userRequestHistoricalMonth(int $userId): array   { return $this->buildHistorical('month',   $userId); }
    public function userRequestHistoricalQuarter(int $userId): array { return $this->buildHistorical('quarter', $userId); }
    public function userRequestHistoricalYear(int $userId): array    { return $this->buildHistorical('year',    $userId); }
    public function userRequestHistoricalTotal(int $userId): array   { return $this->buildHistorical('total',   $userId); }

    /****************************************************************** HISTORICAL ******************************************************************/

    public function requestHistoricalToday(): array   { return $this->buildHistorical('today'); }
    public function requestHistoricalWeek(): array    { return $this->buildHistorical('week'); }
    public function requestHistoricalMonth(): array   { return $this->buildHistorical('month'); }
    public function requestHistoricalQuarter(): array { return $this->buildHistorical('quarter'); }
    public function requestHistoricalYear(): array    { return $this->buildHistorical('year'); }
    public function requestHistoricalTotal(): array   { return $this->buildHistorical('total'); }

    /****************************************************************** AGGREGATE HISTORICAL ******************************************************************/

    public function userRequestHistorical(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p, $userId));
    }

    public function requestHistorical(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p));
    }

    /****************************************************************** AVERAGE TIME ******************************************************************/

    public function averageRequestTimeToday(): array   { return $this->buildAverageTime('today'); }
    public function averageRequestTimeWeek(): array    { return $this->buildAverageTime('week'); }
    public function averageRequestTimeMonth(): array   { return $this->buildAverageTime('month'); }
    public function averageRequestTimeQuarter(): array { return $this->buildAverageTime('quarter'); }
    public function averageRequestTimeYear(): array    { return $this->buildAverageTime('year'); }
    public function averageRequestTimeTotal(): array   { return $this->buildAverageTime('total'); }
}