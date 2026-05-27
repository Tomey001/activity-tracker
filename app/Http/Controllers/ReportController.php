<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default date range: last 7 days
        $startDate = $request->get(
            'start_date',
            now()->subDays(7)->format('Y-m-d')
        );
        $endDate = $request->get(
            'end_date',
            now()->format('Y-m-d')
        );
        $statusFilter = $request->get('status', 'all');

        // Build activities query
        $query = Activity::with(['user', 'logs'])
            ->whereBetween('activity_date', [$startDate, $endDate]);

        // Apply status filter if not 'all'
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Get results ordered by date
        $activities = $query
            ->orderBy('activity_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        // withQueryString keeps filters when paginating

        // Get all logs in the date range
        $logs = ActivityLog::with(['user', 'activity'])
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate   . ' 23:59:59',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Summary counts (without pagination)
        $allActivities = Activity::whereBetween(
                'activity_date',
                [$startDate, $endDate]
            )
            ->when($statusFilter !== 'all', function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            })
            ->get();

        $totalCount   = $allActivities->count();
        $doneCount    = $allActivities->where('status', 'done')->count();
        $pendingCount = $allActivities->where('status', 'pending')->count();

        return view('reports.index', compact(
            'activities',
            'logs',
            'startDate',
            'endDate',
            'statusFilter',
            'totalCount',
            'doneCount',
            'pendingCount'
        ));
    }
}