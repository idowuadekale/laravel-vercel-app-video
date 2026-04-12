<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function createAct()
    {
        $activities = Activity::latest()->paginate(10);
        $activitiesAuth = Activity::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('activities.create', ['activities' => $activities, 'activitiesAuth' => $activitiesAuth]);
    }

    public function addEntry(Request $request)
    {
        $data = $request->validate([
            'day' => 'required|string|max:250',
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'time1' => 'required',
            'time2' => 'required',
        ]);
        $data['updated_by'] = Auth::id();
        $data['time1'] = date('H:i:s', strtotime($data['time1']));
        $data['time2'] = date('H:i:s', strtotime($data['time2']));

        $activity = Activity::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $activity, [
            'created_fields' => $activity->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editAct(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function saveEntry(Activity $activity, Request $request)
    {
        $data = $request->validate([
            'day' => 'required|string|max:250',
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'time1' => 'required',
            'time2' => 'required',
        ]);
        $data['time1'] = date('H:i:s', strtotime($data['time1']));
        $data['time2'] = date('H:i:s', strtotime($data['time2']));
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $activity->getOriginal();

        // ---- Update the team record ----
        $activity->update($data);

        // Detect changed fields only
        $changes = $activity->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $activity, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('activities.create')->with('success', 'Record updated successfully!');
    }

    public function destroy(Activity $activity)
    {
        // Save original values before deletion
        $old = $activity->toArray();

        // Delete the record
        $activity->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $activity, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('activities.create')->with('success', 'Record deleted successfully!');
    }
}
