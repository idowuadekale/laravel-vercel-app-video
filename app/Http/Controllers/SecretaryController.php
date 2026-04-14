<?php

namespace App\Http\Controllers;

use App\Models\Secretary;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $secretary = Secretary::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['updated_by'] = Auth::id();

        $old = $secretary->getOriginal();

        if ($request->hasFile('image')) {
            if ($secretary->image) {
                $this->deleteFromCloudinary($secretary->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $secretary->update($data);
        $changes = $secretary->getChanges();
        unset($changes['updated_at']);

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
        $old = $secretary->toArray();

        if ($secretary->image) {
            $this->deleteFromCloudinary($secretary->image);
        }

        $secretary->delete();

        AuditService::log('deleted', $secretary, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('secretaries.create')->with('success', 'Record deleted successfully!');
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
