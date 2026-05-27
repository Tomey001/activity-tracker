<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DailyViewController extends Controller
{
    /**
     * Show the daily view for a selected date
     */
    public function index(Request $request)
    {
        // Get selected date from URL, default to today
        $date = $request->get('date', date('Y-m-d'));

        // Get ALL activities for that date
        // Also load the user who created each activity
        $activities = Activity::with(['user', 'logs.user'])
            ->where('activity_date', $date)
            ->orderBy('created_at', 'asc')
            ->get();

        // Get ALL logs for that date (for full audit trail)
        // This shows every single update made on this day
        $allLogs = ActivityLog::with(['user', 'activity'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate summary numbers
        $totalActivities = $activities->count();
        $doneActivities  = $activities->where('status', 'done')->count();
        $pendingActivities = $activities->where('status', 'pending')->count();

        return view('daily.index', compact(
            'activities',
            'allLogs',
            'date',
            'totalActivities',
            'doneActivities',
            'pendingActivities'
        ));
    }
}