<?php

namespace ByCarmona141\KingMonitor\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KingMonitorUserExceeded extends Model
{
    use HasFactory;

    public const TYPE_REQUEST = 1;
    public const TYPE_ERROR   = 2;

    protected $fillable = [
        'type',
        'king_user_id',
        'token',
        'ip',
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

    public function scopeOfType(Builder $query, int $type): Builder
    {
        return $query->where('type', $type);
    }

    /****************************************************************** LIMIT ******************************************************************/

    public function limit(): bool
    {
        return $this->hasExceededToday(self::TYPE_REQUEST);
    }

    public function limitError(): bool
    {
        return $this->hasExceededToday(self::TYPE_ERROR);
    }

    private function hasExceededToday(int $type): bool
    {
        $userId = auth()->id();

        return self::whereDate('created_at', today())
                ->ofType($type)
                ->where('king_user_id', $userId)
                ->exists()
            && self::whereDate('created_at', today())
                ->where('token', request()->bearerToken())
                ->exists()
            && self::whereDate('created_at', today())
                ->where('ip', request()->getClientIp())
                ->exists();
    }

    /****************************************************************** PRIVATE HELPERS ******************************************************************/

    private function buildExceeded(string $period, string $field): mixed
    {
        return self::forPeriod($period)->distinct()->pluck($field);
    }

    private function buildUserStatistics(string $period, int $userId, ?int $type = null): array
    {
        $query = fn() => $type
            ? self::forPeriod($period)->ofType($type)->where('king_user_id', $userId)
            : self::forPeriod($period)->where('king_user_id', $userId);

        return [
            'total' => $query()->count(),
            'ip'    => $query()->whereNotNull('ip')->pluck('ip')->mode(),
        ];
    }

    private function buildGlobalStatistics(string $period, ?int $type = null): array
    {
        $query = fn() => $type
            ? self::forPeriod($period)->ofType($type)
            : self::forPeriod($period);

        return [
            'total' => $query()->count(),
            'user'  => $query()->whereNotNull('king_user_id')->pluck('king_user_id')->mode(),
            'ip'    => $query()->whereNotNull('ip')->pluck('ip')->mode(),
        ];
    }

    private function buildHistorical(string $period, ?int $type = null, ?int $userId = null): array
    {
        $alias  = $this->aliasForPeriod($period);
        $format = $this->groupFormatForPeriod($period);

        $base = $type ? self::ofType($type) : self::query();

        if ($userId) {
            $base->where('king_user_id', $userId);
        }

        return [
            'total'   => (clone $base)->forPeriod($period)->count(),
            'details' => (clone $base)->forPeriod($period)
                ->select(
                    DB::raw("DATE_FORMAT(created_at, '{$format}') as {$alias}"),
                    DB::raw('count(*) as total')
                )
                ->groupBy($alias)
                ->orderBy($alias)
                ->get(),
        ];
    }

    private function buildCombinedHistorical(string $period, ?int $userId = null): array
    {
        $base = $userId ? self::where('king_user_id', $userId) : self::query();

        return [
            'total'   => (clone $base)->forPeriod($period)->count(),
            'details' => [
                'request' => $this->buildHistorical($period, self::TYPE_REQUEST, $userId)['details'],
                'error'   => $this->buildHistorical($period, self::TYPE_ERROR, $userId)['details'],
            ],
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

    /**
     * Evita registrar el mismo exceso dos veces en el mismo día
     * para el mismo usuario + token + IP.
     */
    public static function alreadyRegisteredToday(): bool
    {
        return static::query()
            ->whereDate('created_at', today())
            ->where('type', self::TYPE_ERROR)
            ->where(function ($q) {
                $q->where('king_user_id', auth()->id())
                    ->orWhere('token', request()->bearerToken());
            })
            ->exists();
    }

    /****************************************************************** EXCEEDED: USER / TOKEN / IP ******************************************************************/

    public function userExceededToday(): mixed   { return $this->buildExceeded('today',   'king_user_id'); }
    public function userExceededWeek(): mixed    { return $this->buildExceeded('week',    'king_user_id'); }
    public function userExceededMonth(): mixed   { return $this->buildExceeded('month',   'king_user_id'); }
    public function userExceededQuarter(): mixed { return $this->buildExceeded('quarter', 'king_user_id'); }
    public function userExceededYear(): mixed    { return $this->buildExceeded('year',    'king_user_id'); }
    public function userExceededTotal(): mixed   { return $this->buildExceeded('total',   'king_user_id'); }

    public function tokenExceededToday(): mixed   { return $this->buildExceeded('today',   'token'); }
    public function tokenExceededWeek(): mixed    { return $this->buildExceeded('week',    'token'); }
    public function tokenExceededMonth(): mixed   { return $this->buildExceeded('month',   'token'); }
    public function tokenExceededQuarter(): mixed { return $this->buildExceeded('quarter', 'token'); }
    public function tokenExceededYear(): mixed    { return $this->buildExceeded('year',    'token'); }
    public function tokenExceededTotal(): mixed   { return $this->buildExceeded('total',   'token'); }

    public function ipExceededToday(): mixed   { return $this->buildExceeded('today',   'ip'); }
    public function ipExceededWeek(): mixed    { return $this->buildExceeded('week',    'ip'); }
    public function ipExceededMonth(): mixed   { return $this->buildExceeded('month',   'ip'); }
    public function ipExceededQuarter(): mixed { return $this->buildExceeded('quarter', 'ip'); }
    public function ipExceededYear(): mixed    { return $this->buildExceeded('year',    'ip'); }
    public function ipExceededTotal(): mixed   { return $this->buildExceeded('total',   'ip'); }

    /****************************************************************** USER STATISTICS ******************************************************************/

    public function userRequestStatisticsExceededToday(int $userId): array   { return $this->buildUserStatistics('today',   $userId, self::TYPE_REQUEST); }
    public function userRequestStatisticsExceededWeek(int $userId): array    { return $this->buildUserStatistics('week',    $userId, self::TYPE_REQUEST); }
    public function userRequestStatisticsExceededMonth(int $userId): array   { return $this->buildUserStatistics('month',   $userId, self::TYPE_REQUEST); }
    public function userRequestStatisticsExceededQuarter(int $userId): array { return $this->buildUserStatistics('quarter', $userId, self::TYPE_REQUEST); }
    public function userRequestStatisticsExceededYear(int $userId): array    { return $this->buildUserStatistics('year',    $userId, self::TYPE_REQUEST); }
    public function userRequestStatisticsExceededTotal(int $userId): array   { return $this->buildUserStatistics('total',   $userId, self::TYPE_REQUEST); }

    public function userErrorStatisticsExceededToday(int $userId): array   { return $this->buildUserStatistics('today',   $userId, self::TYPE_ERROR); }
    public function userErrorStatisticsExceededWeek(int $userId): array    { return $this->buildUserStatistics('week',    $userId, self::TYPE_ERROR); }
    public function userErrorStatisticsExceededMonth(int $userId): array   { return $this->buildUserStatistics('month',   $userId, self::TYPE_ERROR); }
    public function userErrorStatisticsExceededQuarter(int $userId): array { return $this->buildUserStatistics('quarter', $userId, self::TYPE_ERROR); }
    public function userErrorStatisticsExceededYear(int $userId): array    { return $this->buildUserStatistics('year',    $userId, self::TYPE_ERROR); }
    public function userErrorStatisticsExceededTotal(int $userId): array   { return $this->buildUserStatistics('total',   $userId, self::TYPE_ERROR); }

    public function userStatisticsExceededToday(int $userId): array   { return $this->buildUserStatistics('today',   $userId); }
    public function userStatisticsExceededWeek(int $userId): array    { return $this->buildUserStatistics('week',    $userId); }
    public function userStatisticsExceededMonth(int $userId): array   { return $this->buildUserStatistics('month',   $userId); }
    public function userStatisticsExceededQuarter(int $userId): array { return $this->buildUserStatistics('quarter', $userId); }
    public function userStatisticsExceededYear(int $userId): array    { return $this->buildUserStatistics('year',    $userId); }
    public function userStatisticsExceededTotal(int $userId): array   { return $this->buildUserStatistics('total',   $userId); }

    /****************************************************************** STATISTICS ******************************************************************/

    public function requestStatisticsExceededToday(): array   { return $this->buildGlobalStatistics('today',   self::TYPE_REQUEST); }
    public function requestStatisticsExceededWeek(): array    { return $this->buildGlobalStatistics('week',    self::TYPE_REQUEST); }
    public function requestStatisticsExceededMonth(): array   { return $this->buildGlobalStatistics('month',   self::TYPE_REQUEST); }
    public function requestStatisticsExceededQuarter(): array { return $this->buildGlobalStatistics('quarter', self::TYPE_REQUEST); }
    public function requestStatisticsExceededYear(): array    { return $this->buildGlobalStatistics('year',    self::TYPE_REQUEST); }
    public function requestStatisticsExceededTotal(): array   { return $this->buildGlobalStatistics('total',   self::TYPE_REQUEST); }

    public function errorStatisticsExceededToday(): array   { return $this->buildGlobalStatistics('today',   self::TYPE_ERROR); }
    public function errorStatisticsExceededWeek(): array    { return $this->buildGlobalStatistics('week',    self::TYPE_ERROR); }
    public function errorStatisticsExceededMonth(): array   { return $this->buildGlobalStatistics('month',   self::TYPE_ERROR); }
    public function errorStatisticsExceededQuarter(): array { return $this->buildGlobalStatistics('quarter', self::TYPE_ERROR); }
    public function errorStatisticsExceededYear(): array    { return $this->buildGlobalStatistics('year',    self::TYPE_ERROR); }
    public function errorStatisticsExceededTotal(): array   { return $this->buildGlobalStatistics('total',   self::TYPE_ERROR); }

    public function statisticsExceededToday(): array   { return $this->buildGlobalStatistics('today'); }
    public function statisticsExceededWeek(): array    { return $this->buildGlobalStatistics('week'); }
    public function statisticsExceededMonth(): array   { return $this->buildGlobalStatistics('month'); }
    public function statisticsExceededQuarter(): array { return $this->buildGlobalStatistics('quarter'); }
    public function statisticsExceededYear(): array    { return $this->buildGlobalStatistics('year'); }
    public function statisticsExceededTotal(): array   { return $this->buildGlobalStatistics('total'); }

    /****************************************************************** AGGREGATE STATISTICS ******************************************************************/

    public function userRequestStatisticsExceeded(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildUserStatistics($p, $userId, self::TYPE_REQUEST));
    }

    public function userErrorStatisticsExceeded(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildUserStatistics($p, $userId, self::TYPE_ERROR));
    }

    public function userStatisticsExceeded(int $userId): array
    {
        return [
            'request' => $this->userRequestStatistics($userId),
            'errors'  => $this->userErrorStatistics($userId),
        ];
    }

    public function requestStatisticsExceeded(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildGlobalStatistics($p, self::TYPE_REQUEST));
    }

    public function errorStatisticsExceeded(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildGlobalStatistics($p, self::TYPE_ERROR));
    }

    public function statisticsExceeded(): array
    {
        return [
            'request' => $this->requestStatisticsExceeded(),
            'errors'  => $this->errorStatisticsExceeded(),
        ];
    }

    /****************************************************************** USER HISTORICAL ******************************************************************/

    public function userRequestHistoricalExceededToday(int $userId): array   { return $this->buildHistorical('today',   self::TYPE_REQUEST, $userId); }
    public function userRequestHistoricalExceededWeek(int $userId): array    { return $this->buildHistorical('week',    self::TYPE_REQUEST, $userId); }
    public function userRequestHistoricalExceededMonth(int $userId): array   { return $this->buildHistorical('month',   self::TYPE_REQUEST, $userId); }
    public function userRequestHistoricalExceededQuarter(int $userId): array { return $this->buildHistorical('quarter', self::TYPE_REQUEST, $userId); }
    public function userRequestHistoricalExceededYear(int $userId): array    { return $this->buildHistorical('year',    self::TYPE_REQUEST, $userId); }
    public function userRequestHistoricalExceededTotal(int $userId): array   { return $this->buildHistorical('total',   self::TYPE_REQUEST, $userId); }

    public function userErrorHistoricalExceededToday(int $userId): array   { return $this->buildHistorical('today',   self::TYPE_ERROR, $userId); }
    public function userErrorHistoricalExceededWeek(int $userId): array    { return $this->buildHistorical('week',    self::TYPE_ERROR, $userId); }
    public function userErrorHistoricalExceededMonth(int $userId): array   { return $this->buildHistorical('month',   self::TYPE_ERROR, $userId); }
    public function userErrorHistoricalExceededQuarter(int $userId): array { return $this->buildHistorical('quarter', self::TYPE_ERROR, $userId); }
    public function userErrorHistoricalExceededYear(int $userId): array    { return $this->buildHistorical('year',    self::TYPE_ERROR, $userId); }
    public function userErrorHistoricalExceededTotal(int $userId): array   { return $this->buildHistorical('total',   self::TYPE_ERROR, $userId); }

    public function userHistoricalExceededToday(int $userId): array   { return $this->buildCombinedHistorical('today',   $userId); }
    public function userHistoricalExceededWeek(int $userId): array    { return $this->buildCombinedHistorical('week',    $userId); }
    public function userHistoricalExceededMonth(int $userId): array   { return $this->buildCombinedHistorical('month',   $userId); }
    public function userHistoricalExceededQuarter(int $userId): array { return $this->buildCombinedHistorical('quarter', $userId); }
    public function userHistoricalExceededYear(int $userId): array    { return $this->buildCombinedHistorical('year',    $userId); }
    public function userHistoricalExceededTotal(int $userId): array   { return $this->buildCombinedHistorical('total',   $userId); }

    /****************************************************************** HISTORICAL ******************************************************************/

    public function requestHistoricalExceededToday(): array   { return $this->buildHistorical('today',   self::TYPE_REQUEST); }
    public function requestHistoricalExceededWeek(): array    { return $this->buildHistorical('week',    self::TYPE_REQUEST); }
    public function requestHistoricalExceededMonth(): array   { return $this->buildHistorical('month',   self::TYPE_REQUEST); }
    public function requestHistoricalExceededQuarter(): array { return $this->buildHistorical('quarter', self::TYPE_REQUEST); }
    public function requestHistoricalExceededYear(): array    { return $this->buildHistorical('year',    self::TYPE_REQUEST); }
    public function requestHistoricalExceededTotal(): array   { return $this->buildHistorical('total',   self::TYPE_REQUEST); }

    public function errorHistoricalExceededToday(): array   { return $this->buildHistorical('today',   self::TYPE_ERROR); }
    public function errorHistoricalExceededWeek(): array    { return $this->buildHistorical('week',    self::TYPE_ERROR); }
    public function errorHistoricalExceededMonth(): array   { return $this->buildHistorical('month',   self::TYPE_ERROR); }
    public function errorHistoricalExceededQuarter(): array { return $this->buildHistorical('quarter', self::TYPE_ERROR); }
    public function errorHistoricalExceededYear(): array    { return $this->buildHistorical('year',    self::TYPE_ERROR); }
    public function errorHistoricalExceededTotal(): array   { return $this->buildHistorical('total',   self::TYPE_ERROR); }

    public function historicalExceededToday(): array   { return $this->buildCombinedHistorical('today'); }
    public function historicalExceededWeek(): array    { return $this->buildCombinedHistorical('week'); }
    public function historicalExceededMonth(): array   { return $this->buildCombinedHistorical('month'); }
    public function historicalExceededQuarter(): array { return $this->buildCombinedHistorical('quarter'); }
    public function historicalExceededYear(): array    { return $this->buildCombinedHistorical('year'); }
    public function historicalExceededTotal(): array   { return $this->buildCombinedHistorical('total'); }

    /****************************************************************** AGGREGATE HISTORICAL ******************************************************************/

    public function userRequestHistoricalExceeded(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p, self::TYPE_REQUEST, $userId));
    }

    public function userErrorHistoricalExceeded(int $userId): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p, self::TYPE_ERROR, $userId));
    }

    public function userHistoricalExceeded(int $userId): array
    {
        return [
            'request' => $this->userRequestHistoricalExceeded($userId),
            'errors'  => $this->userErrorHistoricalExceeded($userId),
        ];
    }

    public function requestHistoricalExceeded(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p, self::TYPE_REQUEST));
    }

    public function errorHistoricalExceeded(): array
    {
        return $this->buildAllPeriods(fn($p) => $this->buildHistorical($p, self::TYPE_ERROR));
    }

    public function historicalExceeded(): array
    {
        return [
            'request' => $this->requestHistoricalExceeded(),
            'errors'  => $this->errorHistoricalExceeded(),
        ];
    }
}