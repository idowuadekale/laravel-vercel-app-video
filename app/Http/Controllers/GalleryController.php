<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::paginate(10);

        return view('galleries.index', ['galleries' => $galleries]);
    }

    public function createGallery()
    {
        $galleries = Gallery::latest()->paginate(10);
        $galleriesAuth = Gallery::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('galleries.create', ['galleries' => $galleries, 'galleriesAuth' => $galleriesAuth]);
    }

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'date' => 'required|date',
            'live' => 'nullable|url',
            'link' => 'required|url',
        ]);
        $data['updated_by'] = Auth::id();

        $gallery = Gallery::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $gallery, [
            'created_fields' => $gallery->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editGallery(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    public function updateGallery(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'date' => 'required|date',
            'live' => 'nullable|url',
            'link' => 'required|url',
        ]);

        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $gallery->getOriginal();

        // ---- Update the team record ----
        $gallery->update($data);

        // Detect changed fields only
        $changes = $gallery->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $gallery, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('galleries.create')->with('success', 'Record updated successfully!');
    }

    public function deleteGallery(Gallery $gallery)
    {
        // Save original values before deletion
        $old = $gallery->toArray();

        // Delete the record
        $gallery->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $gallery, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('galleries.create')->with('success', 'Record deleted successfully!');
    }
}
