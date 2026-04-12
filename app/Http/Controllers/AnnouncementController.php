<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(12);

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $announcements = Announcement::latest()->paginate(10);
        $announcementsAuth = Announcement::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('announcements.create', ['announcements' => $announcements, 'announcementsAuth' => $announcementsAuth]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'image_url' => 'nullable|url',
            'tag' => 'nullable|string|max:100',
        ]);
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->title).'-'.uniqid();

        $announcement = Announcement::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $announcement, [
            'created_fields' => $announcement->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'body' => 'required|string',
            'image_url' => 'nullable|url',
            'tag' => 'nullable|string|max:100',
        ]);
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->title).'-'.uniqid();

        // Save original values before changes
        $old = $announcement->getOriginal();

        // ---- Update the record ----
        $announcement->update($data);

        // Detect changed fields only
        $changes = $announcement->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $announcement, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('announcements.create')->with('success', 'Record updated successfully!');
    }

    public function delete(Announcement $announcement)
    {
        // Save original values before deletion
        $old = $announcement->toArray();

        // Delete the record
        $announcement->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $announcement, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('announcements.create')->with('success', 'Record deleted successfully!');
    }
}
