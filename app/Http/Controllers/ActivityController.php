<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * INDEX - Show all activities
     * URL: /activities
     */
    public function index(Request $request)
    {
        // Get activities, newest first
        // Also load the user who created each activity
        $activities = Activity::with('user')
            ->orderBy('activity_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    /**
     * CREATE - Show the form to create a new activity
     * URL: /activities/create
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * STORE - Save the new activity to database
     * URL: POST /activities
     */
    public function store(Request $request)
    {
        // Step 1: Validate the form input
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:pending,done',
            'activity_date' => 'required|date',
        ]);

        // Step 2: Add the logged-in user's ID
        $validated['user_id'] = Auth::id();

        // Step 3: Save the activity
        $activity = Activity::create($validated);

        // Step 4: Create the first activity log entry
        // This records who created it and when
        ActivityLog::create([
            'activity_id' => $activity->id,
            'user_id'     => Auth::id(),
            'old_status'  => null,
            'new_status'  => $activity->status,
            'remark'      => 'Activity created.',
        ]);

        // Step 5: Redirect with success message
        return redirect()
            ->route('activities.index')
            ->with('success', '✅ Activity created successfully!');
    }

    /**
     * SHOW - View a single activity with all its logs
     * URL: /activities/{id}
     */
    public function show(Activity $activity)
    {
        // Load logs with the user who made each update
        // Most recent logs first
        $logs = $activity->logs()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('activities.show', compact('activity', 'logs'));
    }

    /**
     * EDIT - Show the edit form
     * URL: /activities/{id}/edit
     */
    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    /**
     * UPDATE - Save changes and log the update
     * URL: PUT /activities/{id}
     */
    public function update(Request $request, Activity $activity)
    {
        // Step 1: Validate input
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:pending,done',
            'activity_date' => 'required|date',
            'remark'        => 'required|string|max:1000',
        ]);

        // Step 2: Remember the OLD status before updating
        $oldStatus = $activity->status;

        // Step 3: Update the activity
        $activity->update([
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'status'        => $validated['status'],
            'activity_date' => $validated['activity_date'],
        ]);

        // Step 4: Save the audit log entry
        // This records EVERY change made, by whom, and when
        ActivityLog::create([
            'activity_id' => $activity->id,
            'user_id'     => Auth::id(),
            'old_status'  => $oldStatus,
            'new_status'  => $validated['status'],
            'remark'      => $validated['remark'],
        ]);

        // Step 5: Redirect with success message
        return redirect()
            ->route('activities.show', $activity->id)
            ->with('success', '✅ Activity updated successfully!');
    }

    /**
     * DESTROY - Delete an activity
     * URL: DELETE /activities/{id}
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', '🗑️ Activity deleted successfully!');
    }
}

