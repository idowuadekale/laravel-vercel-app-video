<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

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

        $birthday = Birthday::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $old = $birthday->getOriginal();

        if ($request->hasFile('image')) {
            if ($birthday->image) {
                $this->deleteFromCloudinary($birthday->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $birthday->update($data);
        $changes = $birthday->getChanges();
        unset($changes['updated_at']);

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
        $old = $birthday->toArray();

        if ($birthday->image) {
            $this->deleteFromCloudinary($birthday->image);
        }

        $birthday->delete();

        AuditService::log('deleted', $birthday, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('birthdays.create')->with('success', 'Record deleted successfully!');
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
