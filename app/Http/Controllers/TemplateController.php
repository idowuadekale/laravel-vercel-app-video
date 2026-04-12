<?php

namespace App\Http\Controllers;

use App\Mail\SubscriberUpdate;
use App\Models\EmailTemplate;
use App\Models\Subscribe;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::latest()->paginate(15);

        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['slug'] = Str::slug($request->subject).'-'.uniqid();

        // Handle image upload + compression
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'mail/'.uniqid().'.jpg';

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
                $path = $file->store('mail', 'public');
            }

            $data['image'] = $path;
        }

        $template = EmailTemplate::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $template, [
            'created_fields' => $template->toArray(),
        ]);

        return redirect()->route('templates.index')->with('success', 'Record created successfully.');
    }

    public function show(EmailTemplate $template)
    {
        return view('templates.show', compact('template'));
    }

    public function edit(EmailTemplate $template)
    {
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['slug'] = Str::slug($request->subject).'-'.uniqid();

        // Save original values before changes
        $old = $template->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($template->image && Storage::disk('public')->exists($template->image)) {
                Storage::disk('public')->delete($template->image);
            }

            $file = $request->file('image');
            $path = 'mail/'.uniqid().'.jpg';

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
                $path = $file->store('mail', 'public');
            }

            $data['image'] = $path;
        }

        // ---- Update the record ----
        $template->update($data);

        // Detect changed fields only
        $changes = $template->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $template, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('templates.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(EmailTemplate $template)
    {
        // Save original values before deletion
        $old = $template->toArray();

        // Delete the program image if exists
        if ($template->image && Storage::disk('public')->exists($template->image)) {
            Storage::disk('public')->delete($template->image);
        }

        // Delete the record
        $template->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $template, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('templates.index')->with('success', 'Record deleted successfully.');
    }

    public function send(EmailTemplate $template)
    {
        $subscribers = Subscribe::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->queue(new SubscriberUpdate(
                    $template->subject,
                    $template->content,
                    $template->image_url,
                    $template->image,
                    $subscriber->email
                ));
        }

        return redirect()->route('templates.index')->with('success', 'Newsletter sent to all subscribers.');
    }
}
