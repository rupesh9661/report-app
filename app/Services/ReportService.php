<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportService
{
    private $perPage = 20;

    /**
     * Get report data with filters and pagination using Query Builder
     */
    public function getReport(array $filters, int $page = 1): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? $this->perPage;

        // Build query using Query Builder
        $query = DB::table('transactions as t')
            ->join('users as u', 't.user_id', '=', 'u.id')
            ->join('games as g', 't.game_id', '=', 'g.id')
            ->join('providers as p', 't.provider_id', '=', 'p.id')
            ->select([
                't.id',
                't.transaction_code',
                't.amount',
                't.status',
                't.type',
                't.transaction_date',
                't.description',
                'u.id as user_id',
                'u.name as user_name',
                'u.email as user_email',
                'g.id as game_id',
                'g.name as game_name',
                'g.code as game_code',
                'g.category as game_category',
                'p.id as provider_id',
                'p.name as provider_name',
                'p.code as provider_code'
            ]);

        // Apply filters
        $this->applyFilters($query, $filters);

        // Order by
        $query->orderBy('t.transaction_date', 'desc')
              ->orderBy('t.id', 'desc');

        // Return paginated results
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, array $filters): void
    {
        // Date range filter
        if (!empty($filters['date_from'])) {
            $query->where('t.transaction_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('t.transaction_date', '<=', $filters['date_to']);
        }

        // Status filter
        if (!empty($filters['status'])) {
            $query->where('t.status', $filters['status']);
        }

        // User ID filter
        if (!empty($filters['user_id'])) {
            $query->where('t.user_id', $filters['user_id']);
        }

        // Game filter
        if (!empty($filters['game_id'])) {
            $query->where('t.game_id', $filters['game_id']);
        }

        // Provider filter
        if (!empty($filters['provider_id'])) {
            $query->where('t.provider_id', $filters['provider_id']);
        }

        // Amount range filter
        if (!empty($filters['amount_min'])) {
            $query->where('t.amount', '>=', $filters['amount_min']);
        }

        if (!empty($filters['amount_max'])) {
            $query->where('t.amount', '<=', $filters['amount_max']);
        }
    }

    /**
     * Get filter options for dropdowns
     */
    public function getFilterOptions(): array
    {
        // Get unique statuses
        $statuses = DB::select("
            SELECT DISTINCT status 
            FROM transactions 
            ORDER BY status
        ");

        return [
            'statuses' => $statuses,
        ];
    }
}
