<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(12);

        return view('programs.index', compact('programs'));
    }

    public function createPro()
    {
        $programs = Program::latest()->paginate(10);
        $programsAuth = Program::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('programs.create', ['programs' => $programs, 'programsAuth' => $programsAuth]);
    }

    public function addEntry(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'name' => 'required|string|max:250',
            'semester' => 'required|string|max:100',
            'details' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
            'rsvp' => 'nullable|url',
        ]);
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->name).'-'.uniqid();
        $data['time'] = date('H:i:s', strtotime($data['time']));

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

        $program = Program::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $program, [
            'created_fields' => $program->toArray(),
        ]);

        return redirect()->back()->with('success', 'Record created successfully');
    }

    public function editPro(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function saveEntry(Program $program, Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'name' => 'required|string|max:250',
            'semester' => 'required|string|max:100',
            'details' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
            'rsvp' => 'nullable|url',
        ]);
        $data['time'] = date('H:i:s', strtotime($data['time']));
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->name).'-'.uniqid();

        // Save original values before changes
        $old = $program->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
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
        $program->update($data);

        // Detect changed fields only
        $changes = $program->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $program, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('programs.create')->with('success', 'Record updated successfully!');
    }

    public function showPro(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    public function destroyPro(Program $program)
    {
        // Save original values before deletion
        $old = $program->toArray();

        // Delete the program image if exists
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        // Delete the record
        $program->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $program, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('programs.create')->with('success', 'Record deleted successfully!');
    }
}
