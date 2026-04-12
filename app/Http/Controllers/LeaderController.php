<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::latest()->paginate(20);

        return view('leaders.index', compact('leaders'));
    }

    public function create()
    {
        $leaders = Leader::latest()->paginate(10);

        return view('leaders.create', ['leaders' => $leaders]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'class' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);

        // Handle image upload + compression
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'imageUpload/'.uniqid().'.jpg';

            // Compress only if >5MB
            if ($file->getSize() > 5 * 1024 * 1024) {
                $imgResource = null;

                if (in_array($file->extension(), ['jpg', 'jpeg'])) {
                    $imgResource = imagecreatefromjpeg($file->getRealPath());
                    imagejpeg($imgResource, storage_path('app/public/'.$path), 75); // 75% quality
                }

                if ($file->extension() === 'png') {
                    $imgResource = imagecreatefrompng($file->getRealPath());
                    imagepng($imgResource, storage_path('app/public/'.$path), 6); // compression level 0-9
                }

                if ($imgResource) {
                    imagedestroy($imgResource);
                }
            } else {
                $path = $file->store('imageUpload', 'public');
            }

            $data['image'] = $path;
        }

        $leader = Leader::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $leader, [
            'created_fields' => $leader->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function edit(Leader $leader)
    {
        return view('leaders.edit', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'class' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);

        // Save original values before changes
        $old = $leader->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($leader->image && Storage::disk('public')->exists($leader->image)) {
                Storage::disk('public')->delete($leader->image);
            }

            $file = $request->file('image');
            $path = 'imageUpload/'.uniqid().'.jpg';

            // Compress if >5MB
            if ($file->getSize() > 5 * 1024 * 1024) {
                $imgResource = null;

                if (in_array($file->extension(), ['jpg', 'jpeg'])) {
                    $imgResource = imagecreatefromjpeg($file->getRealPath());
                    imagejpeg($imgResource, storage_path('app/public/'.$path), 75);
                }

                if ($file->extension() === 'png') {
                    $imgResource = imagecreatefrompng($file->getRealPath());
                    imagepng($imgResource, storage_path('app/public/'.$path), 6);
                }

                if ($imgResource) {
                    imagedestroy($imgResource);
                }
            } else {
                $path = $file->store('imageUpload', 'public');
            }

            $data['image'] = $path;
        }

        // ---- Update the record ----
        $leader->update($data);

        // Detect changed fields only
        $changes = $leader->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $leader, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('leaders.create')->with('success', 'Record updated successfully!');
    }

    public function delete(Leader $leader)
    {
        // Save original values before deletion
        $old = $leader->toArray();

        // Delete the program image if exists
        if ($leader->image && Storage::disk('public')->exists($leader->image)) {
            Storage::disk('public')->delete($leader->image);
        }

        // Delete the record
        $leader->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $leader, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('leaders.create')->with('success', 'Record deleted successfully!');
    }
}
