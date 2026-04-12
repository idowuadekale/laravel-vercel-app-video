<?php

namespace App\Http\Controllers;

use App\Models\AdministrationYear;
use App\Models\Executive;
use App\Models\Secretary;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExecutiveController extends Controller
{
    public function index()
    {
        // Priority order
        $priority = [
            'President',
            'Vice President',
            'Chapter Secretary',
            'Assistant Chapter Secretary',
            'Female Coordinator',
        ];

        $executives = Executive::orderByRaw("
    CASE 
        WHEN position = 'President' THEN 1
        WHEN position = 'Vice President' THEN 2
        WHEN position = 'Chapter Secretary' THEN 3
        WHEN position = 'Assistant Chapter Secretary' THEN 4
        WHEN position = 'Female Coordinator' THEN 5
        ELSE 6
    END
")->orderBy('position', 'asc') // other positions in alphabetical order
            ->paginate(10);

        $secretaries = Secretary::paginate(10);
        $AdmYear = AdministrationYear::first();

        return view('executives.index', compact('executives', 'secretaries', 'AdmYear'));
    }

    public function createEx()
    {
        $executives = Executive::latest()->paginate(10);
        $executivesAuth = Executive::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('executives.create', ['executives' => $executives, 'executivesAuth' => $executivesAuth]);
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
        $executive = Executive::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $executive, [
            'created_fields' => $executive->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editEx(Executive $executive)
    {
        return view('executives.edit', compact('executive'));
    }

    public function saveEntry(Executive $executive, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'instagram' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $executive->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($executive->image && Storage::disk('public')->exists($executive->image)) {
                Storage::disk('public')->delete($executive->image);
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
        $executive->update($data);

        // Detect changed fields only
        $changes = $executive->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $executive, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('executives.create')->with('success', 'Record updated successfully!');
    }

    public function destroy(Executive $executive)
    {
        // Save original values before deletion
        $old = $executive->toArray();

        // Delete the team image if exists
        if ($executive->image && Storage::disk('public')->exists($executive->image)) {
            Storage::disk('public')->delete($executive->image);
        }

        // Delete the record
        $executive->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $executive, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('executives.create')->with('success', 'Record deleted successfully!');
    }
}
