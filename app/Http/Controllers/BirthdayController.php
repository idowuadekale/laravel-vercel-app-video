<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BirthdayController extends Controller
{
    public function index()
    {
        $birthdays = Birthday::latest()->paginate(20);

        return view('birthdays.index', compact('birthdays'));
    }

    public function create()
    {
        $birthdays = Birthday::latest()->paginate(10);

        return view('birthdays.create', ['birthdays' => $birthdays]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'department' => 'required|string',
            'faculty' => 'required|string',
            'unit' => 'required|string',
            'dob' => 'required|date',
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

        $birthday = Birthday::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $birthday, [
            'created_fields' => $birthday->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function edit(Birthday $birthday)
    {
        return view('birthdays.edit', compact('birthday'));
    }

    public function update(Request $request, Birthday $birthday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'department' => 'required|string',
            'faculty' => 'required|string',
            'unit' => 'required|string',
            'dob' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);

        // Save original values before changes
        $old = $birthday->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($birthday->image && Storage::disk('public')->exists($birthday->image)) {
                Storage::disk('public')->delete($birthday->image);
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
        $birthday->update($data);

        // Detect changed fields only
        $changes = $birthday->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $birthday, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('birthdays.create')->with('success', 'Record updated successfully!');
    }

    public function delete(Birthday $birthday)
    {
        // Save original values before deletion
        $old = $birthday->toArray();

        // Delete the program image if exists
        if ($birthday->image && Storage::disk('public')->exists($birthday->image)) {
            Storage::disk('public')->delete($birthday->image);
        }

        // Delete the record
        $birthday->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $birthday, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('birthdays.create')->with('success', 'Record deleted successfully!');
    }
}
