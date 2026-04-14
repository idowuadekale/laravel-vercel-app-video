<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $leader = Leader::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $old = $leader->getOriginal();

        if ($request->hasFile('image')) {
            if ($leader->image) {
                $this->deleteFromCloudinary($leader->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $leader->update($data);
        $changes = $leader->getChanges();
        unset($changes['updated_at']);

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
        $old = $leader->toArray();

        if ($leader->image) {
            $this->deleteFromCloudinary($leader->image);
        }

        $leader->delete();

        AuditService::log('deleted', $leader, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('leaders.create')->with('success', 'Record deleted successfully!');
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
