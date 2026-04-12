<?php

namespace App\Http\Controllers;

use App\Models\Secretary;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SecretaryController extends Controller
{
    public function createSec()
    {
        $secretaries = Secretary::latest()->paginate(10);
        $secretariesAuth = Secretary::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('secretaries.create', ['secretaries' => $secretaries, 'secretariesAuth' => $secretariesAuth]);
    }

    public function addEntry(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'position' => 'required|string|max:150',
            'instagram' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['updated_by'] = Auth::id();

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

        // Save the record
        $secretary = Secretary::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $secretary, [
            'created_fields' => $secretary->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editSec(Secretary $secretary)
    {
        return view('secretaries.edit', compact('secretary'));
    }

    public function saveEntry(Secretary $secretary, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'instagram' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $secretary->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($secretary->image && Storage::disk('public')->exists($secretary->image)) {
                Storage::disk('public')->delete($secretary->image);
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

        // ---- Update the team record ----
        $secretary->update($data);

        // Detect changed fields only
        $changes = $secretary->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $secretary, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('secretaries.create')->with('success', 'Record updated successfully!');
    }

    public function destroy(Secretary $secretary)
    {
        // Save original values before deletion
        $old = $secretary->toArray();

        // Delete the team image if exists
        if ($secretary->image && Storage::disk('public')->exists($secretary->image)) {
            Storage::disk('public')->delete($secretary->image);
        }

        // Delete the record
        $secretary->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $secretary, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('secretaries.create')->with('success', 'Record deleted successfully!');
    }
}
