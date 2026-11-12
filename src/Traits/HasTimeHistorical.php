<?php
namespace ByCarmona141\KingMonitor\Traits;

trait HasTimeHistorical
{
    /**
     * Obtener histórico basado en período
     */
    public function getHistoricalByPeriod(string $period, ?int $userId = null): array
    {
        $query = $this->queryForPeriod($period);

        if ($userId) {
            $query->where('king_user_id', $userId);
        }

        return [
            'total' => $query->count(),
            'details' => $this->getHistoricalDetails($period, $userId),
        ];
    }

    /**
     * Obtener detalles del histórico con agrupación temporal
     */
    protected function getHistoricalDetails(string $period, ?int $userId = null)
    {
        $query = $this->queryForPeriod($period);

        if ($userId) {
            $query->where('king_user_id', $userId);
        }

        $format = $this->getDateFormatForPeriod($period);
        $groupBy = $this->getGroupByForPeriod($period);

        return $query->selectRaw("DATE_FORMAT(created_at, '{$format}') as {$groupBy}, count(*) as total")
            ->groupBy($groupBy)
            ->orderBy($groupBy)
            ->get();
    }

    /**
     * Formato de fecha según período
     */
    protected function getDateFormatForPeriod(string $period): string
    {
        return match($period) {
            'today' => '%H',
            'week', 'month', 'quarter' => '%d',
            'year' => '%M',
            'total' => '%Y',
            default => '%Y-%m-%d'
        };
    }

    /**
     * Campo de agrupación según período
     */
    protected function getGroupByForPeriod(string $period): string
    {
        return match($period) {
            'today' => 'hour',
            'week', 'month', 'quarter' => 'day',
            'year' => 'month',
            'total' => 'year',
            default => 'date'
        };
    }
}