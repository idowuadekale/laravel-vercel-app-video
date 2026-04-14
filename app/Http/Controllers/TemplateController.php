<?php

namespace App\Http\Controllers;

use App\Mail\SubscriberUpdate;
use App\Models\EmailTemplate;
use App\Models\Subscribe;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['slug'] = Str::slug($request->subject).'-'.uniqid();

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'mail',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $template = EmailTemplate::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['slug'] = Str::slug($request->subject).'-'.uniqid();

        $old = $template->getOriginal();

        if ($request->hasFile('image')) {
            if ($template->image) {
                $this->deleteFromCloudinary($template->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'mail',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $template->update($data);
        $changes = $template->getChanges();
        unset($changes['updated_at']);

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
        $old = $template->toArray();

        if ($template->image) {
            $this->deleteFromCloudinary($template->image);
        }

        $template->delete();

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
                    $template->image, // already a full https:// URL now
                    $subscriber->email
                ));
        }

        return redirect()->route('templates.index')->with('success', 'Newsletter sent to all subscribers.');
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
