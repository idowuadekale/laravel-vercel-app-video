<?php

namespace App\Http\Controllers;

use App\Models\AdministrationYear;
use App\Models\Executive;
use App\Models\Secretary;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExecutiveController extends Controller
{
    public function index()
    {
        $executives = Executive::orderByRaw("
            CASE
                WHEN position = 'President' THEN 1
                WHEN position = 'Vice President' THEN 2
                WHEN position = 'Chapter Secretary' THEN 3
                WHEN position = 'Assistant Chapter Secretary' THEN 4
                WHEN position = 'Female Coordinator' THEN 5
                ELSE 6
            END
        ")->orderBy('position', 'asc')->paginate(10);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $executive = Executive::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['updated_by'] = Auth::id();

        $old = $executive->getOriginal();

        if ($request->hasFile('image')) {
            if ($executive->image) {
                $this->deleteFromCloudinary($executive->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $executive->update($data);
        $changes = $executive->getChanges();
        unset($changes['updated_at']);

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
        $old = $executive->toArray();

        if ($executive->image) {
            $this->deleteFromCloudinary($executive->image);
        }

        $executive->delete();

        AuditService::log('deleted', $executive, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('executives.create')->with('success', 'Record deleted successfully!');
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
