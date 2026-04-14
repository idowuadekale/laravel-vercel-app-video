<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'rsvp' => 'nullable|url',
        ]);
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->name).'-'.uniqid();
        $data['time'] = date('H:i:s', strtotime($data['time']));

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $program = Program::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'rsvp' => 'nullable|url',
        ]);
        $data['time'] = date('H:i:s', strtotime($data['time']));
        $data['updated_by'] = Auth::id();
        $data['slug'] = Str::slug($request->name).'-'.uniqid();

        $old = $program->getOriginal();

        if ($request->hasFile('image')) {
            if ($program->image) {
                $this->deleteFromCloudinary($program->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $program->update($data);
        $changes = $program->getChanges();
        unset($changes['updated_at']);

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
        $old = $program->toArray();

        if ($program->image) {
            $this->deleteFromCloudinary($program->image);
        }

        $program->delete();

        AuditService::log('deleted', $program, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('programs.create')->with('success', 'Record deleted successfully!');
    }

    private function deleteFromCloudinary(string $url): void
    {
        try {
            if (preg_match('/\/image\/upload\/(?:v\d+\/)?(.+)\.[a-z]+$/i', $url, $matches)) {
                Cloudinary::destroy($matches[1]);
            }
        } catch (\Exception $e) {
        }
    }
}
