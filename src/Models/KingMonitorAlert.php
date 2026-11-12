<?php

namespace ByCarmona141\KingMonitor\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KingMonitorAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'king_user_id',
        'token',
        'ip',
        'description',
    ];

    protected $casts = [
        'id'           => 'integer',
        'king_user_id' => 'integer',
    ];

    /****************************************************************** QUERY SCOPES ******************************************************************/

    public function scopeForPeriod(Builder $query, string $period, ?int $userId = null): Builder
    {
        $query = match ($period) {
            'today'   => $query->whereDate('created_at', today()),
            'week'    => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'month'   => $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month),
            'quarter' => $query->whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]),
            'year'    => $query->whereYear('created_at', now()->year),
            default   => $query, // total
        };

        return $userId ? $query->where('king_user_id', $userId) : $query;
    }

    /****************************************************************** LAST ALERT ******************************************************************/

    public function lastAlertToday(): ?self
    {
        return self::whereDate('created_at', today())
            ->where('king_user_id', auth()->id())
            ->latest()
            ->first();
    }

    /****************************************************************** PRIVATE HELPERS ******************************************************************/

    private function buildStatistics(string $period, ?int $userId = null): array
    {
        $query = fn() => self::forPeriod($period, $userId);

        return [
            'total' => $query()->count(),
            'ip'    => $query()->whereNotNull('ip')->pluck('ip')->mode(),
        ];
    }

    private function buildGlobalStatistics(string $period): array
    {
        $query = fn() => self::forPeriod($period);

        return [
            'total' => $query()->count(),
            'user'  => $query()->whereNotNull('king_user_id')->pluck('king_user_id')->mode(),
            'ip'    => $query()->whereNotNull('ip')->pluck('ip')->mode(),
        ];
    }

    private function buildHistorical(string $period, ?int $userId = null): array
    {
        $groupFormat = $this->groupFormatForPeriod($period);
        $alias       = $this->aliasForPeriod($period);

        $query = self::forPeriod($period, $userId)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '{$groupFormat}') as {$alias}"),
                DB::raw('count(*) as total')
            )
            ->groupBy($alias)
            ->orderBy($alias);

        return [
            'total'   => self::forPeriod($period, $userId)->count(),
            'details' => $query->get(),
        ];
    }

    private function groupFormatForPeriod(string $period): string
    {
        return match ($period) {
            'today'           => '%H',
            'week', 'month',
            'quarter'         => '%d',
            'year'            => '%M',
            default           => '%Y',
        };
    }

    private function aliasForPeriod(string $period): string
    {
        return match ($period) {
            'today'           => 'hour',
            'week', 'month',
            'quarter'         => 'day',
            'year'            => 'month',
            default           => 'year',
        };
    }

    /****************************************************************** USER STATISTICS ******************************************************************/

    public function userStatisticsAlertToday(int $userId): array
    {
        return $this->buildStatistics('today', $userId);
    }

    public function userStatisticsAlertWeek(int $userId): array
    {
        return $this->buildStatistics('week', $userId);
    }

    public function userStatisticsAlertMonth(int $userId): array
    {
        return $this->buildStatistics('month', $userId);
    }

    public function userStatisticsAlertQuarter(int $userId): array
    {
        return $this->buildStatistics('quarter', $userId);
    }

    public function userStatisticsAlertYear(int $userId): array
    {
        return $this->buildStatistics('year', $userId);
    }

    public function userStatisticsAlertTotal(int $userId): array
    {
        return $this->buildStatistics('total', $userId);
    }

    /****************************************************************** STATISTICS ******************************************************************/

    public function statisticsAlertToday(): array
    {
        return $this->buildGlobalStatistics('today');
    }

    public function statisticsAlertWeek(): array
    {
        return $this->buildGlobalStatistics('week');
    }

    public function statisticsAlertMonth(): array
    {
        return $this->buildGlobalStatistics('month');
    }

    public function statisticsAlertQuarter(): array
    {
        return $this->buildGlobalStatistics('quarter');
    }

    public function statisticsAlertYear(): array
    {
        return $this->buildGlobalStatistics('year');
    }

    public function statisticsAlertTotal(): array
    {
        return $this->buildGlobalStatistics('total');
    }

    /****************************************************************** USER HISTORICAL ******************************************************************/

    public function userHistoricalAlertToday(int $userId): array
    {
        return $this->buildHistorical('today', $userId);
    }

    public function userHistoricalAlertWeek(int $userId): array
    {
        return $this->buildHistorical('week', $userId);
    }

    public function userHistoricalAlertMonth(int $userId): array
    {
        return $this->buildHistorical('month', $userId);
    }

    public function userHistoricalAlertQuarter(int $userId): array
    {
        return $this->buildHistorical('quarter', $userId);
    }

    public function userHistoricalAlertYear(int $userId): array
    {
        return $this->buildHistorical('year', $userId);
    }

    public function userHistoricalAlertTotal(int $userId): array
    {
        return $this->buildHistorical('total', $userId);
    }

    /****************************************************************** HISTORICAL ******************************************************************/

    public function historicalAlertToday(): array
    {
        return $this->buildHistorical('today');
    }

    public function historicalAlertWeek(): array
    {
        return $this->buildHistorical('week');
    }

    public function historicalAlertMonth(): array
    {
        return $this->buildHistorical('month');
    }

    public function historicalAlertQuarter(): array
    {
        return $this->buildHistorical('quarter');
    }

    public function historicalAlertYear(): array
    {
        return $this->buildHistorical('year');
    }

    public function historicalAlertTotal(): array
    {
        return $this->buildHistorical('total');
    }
}