<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use App\Models\Image;
use App\Models\LandingPage;
use App\Models\SocialMedia;
use App\Models\Team;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    // ---- Social Media ----
    public function editSocial()
    {
        $social = SocialMedia::first();

        return view('admin.social.edit', compact('social'));
    }

    public function updateSocial(Request $request)
    {
        $fields = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'video_link'];

        // Validate dynamically
        $request->validate(
            collect($fields)->mapWithKeys(fn ($field) => [$field => 'nullable|url'])->toArray()
        );

        // Prepare data dynamically
        $data = collect($fields)->mapWithKeys(fn ($field) => [$field => $request->input($field)])->toArray();
        $data['updated_by'] = Auth::id();

        // Get existing record before update (for audit comparison)
        $existing = SocialMedia::first();

        // Update or create record
        $social = SocialMedia::updateOrCreate([], $data);

        // ---- AUDIT TRAIL ----
        // Detect changes
        $changes = [];
        if ($existing) {
            foreach ($fields as $field) {
                if ($existing->$field !== $request->$field) {
                    $changes[$field] = [
                        'old' => $existing->$field,
                        'new' => $request->$field,
                    ];
                }
            }
        } else {
            // If first-time creation
            $changes = [
                'created_fields' => $social->toArray(),
            ];
        }

        // Log only if changes exist
        if (!empty($changes)) {
            AuditService::log('updated', $social, $changes);
        }

        return redirect()->back()->with('success', 'Social handles saved successfully.');
    }

    // ---- Landing Page ----
    public function editLanding()
    {
        $landing = LandingPage::first();

        return view('admin.landing.edit', data: compact('landing'));
    }

    public function updateLanding(Request $request)
    {
        $data = $request->validate([
            'welcome_heading' => 'nullable|string|max:255',
            'welcome_bio' => 'nullable|string|max:255',
            'about_heading' => 'nullable|string|max:255',
            'about_info' => 'nullable|string',
            'about_img' => 'nullable|image|max:20480', // 20MB
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\(\) ]+$/',
            'email' => 'required|string|email|max:255',
            'address' => 'nullable|string|max:300',
            'map' => 'nullable|url',
        ]);
        $data['updated_by'] = Auth::id();

        $landing = LandingPage::first();

        if ($request->hasFile('about_img')) {
            // Delete old image if exists
            if ($landing && $landing->about_img && Storage::disk('public')->exists($landing->about_img)) {
                Storage::disk('public')->delete($landing->about_img);
            }

            $image = $request->file('about_img');
            $path = 'imageUpload/'.uniqid().'.jpg';

            if ($image->getSize() > 5 * 1024 * 1024) { // >5MB compress
                $imgResource = null;

                if (in_array($image->extension(), ['jpg', 'jpeg'])) {
                    $imgResource = imagecreatefromjpeg($image->getRealPath());
                    imagejpeg($imgResource, storage_path('app/public/'.$path), 75);
                } elseif ($image->extension() === 'png') {
                    $imgResource = imagecreatefrompng($image->getRealPath());
                    imagepng($imgResource, storage_path('app/public/'.$path), 6);
                }

                if ($imgResource) {
                    imagedestroy($imgResource);
                    $data['about_img'] = $path;
                } else {
                    $data['about_img'] = $image->store('imageUpload', 'public');
                }
            } else {
                $data['about_img'] = $image->store('imageUpload', 'public');
            }
        }

        if ($landing) {
            // Save original values
            $old = $landing->getOriginal();

            // Update record
            $landing->update($data);

            // Detect changes
            $changes = $landing->getChanges();

            // Remove updated_at from audit
            unset($changes['updated_at']);

            if (!empty($changes)) {
                AuditService::log('updated', $landing, [
                    'old' => array_intersect_key($old, $changes),
                    'new' => $changes,
                ]);
            }
        } else {
            $landing = LandingPage::create($data);

            // Log creation
            AuditService::log('created', $landing, [
                'created_fields' => $landing->toArray(),
            ]);
        }

        return back()->with('success', 'Record updated successfully.');
    }

    // ---- Team ----
    public function createTeam()
    {
        $teams = Team::latest()->paginate(10);
        $teamAuth = Team::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('admin.team.create', ['teams' => $teams, 'teamAuth' => $teamAuth]);
    }

    // ---- Store new team member ----
    public function storeTeam(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'facebook' => 'nullable|url',
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
        $team = Team::create($data);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $team, [
            'created_fields' => $team->toArray(),
        ]);

        return back()->with('success', 'Record created successfully.');
    }

    // ---- Show edit page ----
    public function editTeam(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    // ---- Update existing team member ----
    public function updateTeam(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20MB
        ]);
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $team->getOriginal();

        // ---- Handle image replacement + compression ----
        if ($request->hasFile('image')) {
            // Delete old image
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
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
        $team->update($data);

        // Detect changed fields only
        $changes = $team->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $team, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('team.create')->with('success', 'Record updated successfully!');
    }

    // ---- Delete existing team member ----
    public function deleteTeam(Team $team)
    {
        // Save original values before deletion
        $old = $team->toArray();

        // Delete the team image if exists
        if ($team->image && Storage::disk('public')->exists($team->image)) {
            Storage::disk('public')->delete($team->image);
        }

        // Delete the record
        $team->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $team, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('team.create')->with('success', 'Record deleted successfully!');
    }

    // ---- Image Section ----
    public function createImage()
    {
        $groups = Image::latest()->paginate(10);
        $groupAuth = Image::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('admin.images.create', ['groups' => $groups, 'groupAuth' => $groupAuth]);
    }

    public function storeImage(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480', // 20mb
            'short_bio' => 'nullable|string',
        ]);

        $data['updated_by'] = Auth::id();
        $file = $request->file('image');
        $path = 'imageUpload/'.uniqid().'.jpg';

        // Compress if > 5MB
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

        $image = Image::create($data);

        // AUDIT TRAIL — CREATED
        AuditService::log('created', $image, [
            'created_fields' => $image->toArray(),
        ]);

        return back()->with('success', 'Record created successfully.');
    }

    public function editImage(Image $group)
    {
        return view('admin.images.edit', compact('group'));
    }

    public function updateImage(Request $request, Image $group)
    {
        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20mb
            'short_bio' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        // Save original values before changes
        $old = $group->getOriginal();

        // If new image uploaded
        if ($request->hasFile('image')) {
            // Delete old file
            if ($group->image && Storage::disk('public')->exists($group->image)) {
                Storage::disk('public')->delete($group->image);
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
        $group->update($data);

        // Detect changed fields only
        $changes = $group->getChanges();

        // Remove timestamps from change list (optional)
        unset($changes['updated_at']);

        // Log only if something actually changed
        if (!empty($changes)) {
            AuditService::log('updated', $group, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('images.create')->with('success', 'Record updated successfully!');
    }

    // ---- Delete existing Group Image member ----
    public function deleteImage(Image $group)
    {
        // Save original values before deletion
        $old = $group->toArray();

        // Delete the Group image if exists
        if ($group->image && Storage::disk('public')->exists($group->image)) {
            Storage::disk('public')->delete($group->image);
        }

        // Delete the record
        $group->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $group, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('images.create')->with('success', 'Record deleted successfully!');
    }

    // ---- HeroImage Section ----
    public function createHeroImage()
    {
        $heros = HeroImage::latest()->paginate(10);
        $heroAuth = HeroImage::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('admin.hero.create', ['heros' => $heros, 'heroAuth' => $heroAuth]);
    }

    public function storeHeroImage(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480', // 20mb
        ]);

        $data['updated_by'] = Auth::id();
        $file = $request->file('image');
        $path = 'imageUpload/'.uniqid().'.jpg';

        // Compress if > 5MB
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

        $image = HeroImage::create($data);

        // AUDIT TRAIL — CREATED
        AuditService::log('created', $image, [
            'created_fields' => $image->toArray(),
        ]);

        return back()->with('success', 'Record created successfully.');
    }

    public function deleteHeroImage(HeroImage $hero)
    {
        // Save original values before deletion
        $old = $hero->toArray();

        // Delete the Group image if exists
        if ($hero->image && Storage::disk('public')->exists($hero->image)) {
            Storage::disk('public')->delete($hero->image);
        }

        // Delete the record
        $hero->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $hero, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('hero.create')->with('success', 'Record deleted successfully!');
    }
}
