<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display the report page with filters
     */
    public function index(Request $request)
    {
        // Get filter options for dropdowns
        $filterOptions = $this->reportService->getFilterOptions();
        
        return view('reports.index', [
            'filterOptions' => $filterOptions,
        ]);
    }

    /**
     * Get report data for DataTables AJAX request
     */
    public function getReportData(Request $request)
    {
        $filters = $this->getFiltersFromRequest($request);
        $start = $request->input('start', 0);
        $length = $request->input('length', 20);
        $page = ($start / $length) + 1;
        
        $filters['per_page'] = $length;
        $transactions = $this->reportService->getReport($filters, $page);
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $transactions->total(),
            'recordsFiltered' => $transactions->total(),
            'data' => $transactions->items()
        ]);
    }

    /**
     * Extract filters from request
     */
    private function getFiltersFromRequest(Request $request): array
    {
        return [
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'status' => $request->input('status'),
            'user_id' => $request->input('user_id'),
            'game_id' => $request->input('game_id'),
            'provider_id' => $request->input('provider_id'),
            'amount_min' => $request->input('amount_min'),
            'amount_max' => $request->input('amount_max'),
            'per_page' => $request->input('per_page', 20),
        ];
    }
}
