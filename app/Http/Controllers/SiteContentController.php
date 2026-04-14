<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use App\Models\Image;
use App\Models\LandingPage;
use App\Models\SocialMedia;
use App\Models\Team;
use App\Services\AuditService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $request->validate(
            collect($fields)->mapWithKeys(fn ($field) => [$field => 'nullable|url'])->toArray()
        );

        $data = collect($fields)->mapWithKeys(fn ($field) => [$field => $request->input($field)])->toArray();
        $data['updated_by'] = Auth::id();

        $existing = SocialMedia::first();
        $social = SocialMedia::updateOrCreate([], $data);

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
            $changes = ['created_fields' => $social->toArray()];
        }

        if (!empty($changes)) {
            AuditService::log('updated', $social, $changes);
        }

        return redirect()->back()->with('success', 'Social handles saved successfully.');
    }

    // ---- Landing Page ----
    public function editLanding()
    {
        $landing = LandingPage::first();

        return view('admin.landing.edit', compact('landing'));
    }

    public function updateLanding(Request $request)
    {
        $data = $request->validate([
            'welcome_heading' => 'nullable|string|max:255',
            'welcome_bio' => 'nullable|string|max:255',
            'about_heading' => 'nullable|string|max:255',
            'about_info' => 'nullable|string',
            'about_img' => 'nullable|image|max:20480',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\(\) ]+$/',
            'email' => 'required|string|email|max:255',
            'address' => 'nullable|string|max:300',
            'map' => 'nullable|url',
        ]);
        $data['updated_by'] = Auth::id();

        $landing = LandingPage::first();

        if ($request->hasFile('about_img')) {
            // Delete old image from Cloudinary if it's a Cloudinary URL
            if ($landing && $landing->about_img) {
                $this->deleteFromCloudinary($landing->about_img);
            }

            $uploaded = Cloudinary::upload($request->file('about_img')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['about_img'] = $uploaded->getSecurePath();
        }

        if ($landing) {
            $old = $landing->getOriginal();
            $landing->update($data);
            $changes = $landing->getChanges();
            unset($changes['updated_at']);

            if (!empty($changes)) {
                AuditService::log('updated', $landing, [
                    'old' => array_intersect_key($old, $changes),
                    'new' => $changes,
                ]);
            }
        } else {
            $landing = LandingPage::create($data);
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

    public function storeTeam(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'facebook' => 'nullable|url',
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

        $team = Team::create($data);

        AuditService::log('created', $team, [
            'created_fields' => $team->toArray(),
        ]);

        return back()->with('success', 'Record created successfully.');
    }

    public function editTeam(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function updateTeam(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:150',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $data['updated_by'] = Auth::id();

        $old = $team->getOriginal();

        if ($request->hasFile('image')) {
            // Delete old image from Cloudinary
            if ($team->image) {
                $this->deleteFromCloudinary($team->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $team->update($data);
        $changes = $team->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            AuditService::log('updated', $team, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('team.create')->with('success', 'Record updated successfully!');
    }

    public function deleteTeam(Team $team)
    {
        $old = $team->toArray();

        if ($team->image) {
            $this->deleteFromCloudinary($team->image);
        }

        $team->delete();

        AuditService::log('deleted', $team, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('team.create')->with('success', 'Record deleted successfully!');
    }

    // ---- Gallery Images ----
    public function createImage()
    {
        $groups = Image::latest()->paginate(10);
        $groupAuth = Image::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('admin.images.create', ['groups' => $groups, 'groupAuth' => $groupAuth]);
    }

    public function storeImage(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
            'short_bio' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'imageUpload',
            'quality' => 'auto',
            'fetch_format' => 'auto',
        ]);
        $data['image'] = $uploaded->getSecurePath();

        $image = Image::create($data);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'short_bio' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();

        $old = $group->getOriginal();

        if ($request->hasFile('image')) {
            if ($group->image) {
                $this->deleteFromCloudinary($group->image);
            }

            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'imageUpload',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $group->update($data);
        $changes = $group->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            AuditService::log('updated', $group, [
                'old' => array_intersect_key($old, $changes),
                'new' => $changes,
            ]);
        }

        return redirect()->route('images.create')->with('success', 'Record updated successfully!');
    }

    public function deleteImage(Image $group)
    {
        $old = $group->toArray();

        if ($group->image) {
            $this->deleteFromCloudinary($group->image);
        }

        $group->delete();

        AuditService::log('deleted', $group, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('images.create')->with('success', 'Record deleted successfully!');
    }

    // ---- Hero Image ----
    public function createHeroImage()
    {
        $heros = HeroImage::latest()->paginate(10);
        $heroAuth = HeroImage::orderByRaw('GREATEST(created_at, updated_at) DESC')->first();

        return view('admin.hero.create', ['heros' => $heros, 'heroAuth' => $heroAuth]);
    }

    public function storeHeroImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'imageUpload',
            'quality' => 'auto',
            'fetch_format' => 'auto',
        ]);

        $image = HeroImage::create([
            'image' => $uploaded->getSecurePath(),
            'updated_by' => Auth::id(),
        ]);

        AuditService::log('created', $image, [
            'created_fields' => $image->toArray(),
        ]);

        return back()->with('success', 'Record created successfully.');
    }

    public function deleteHeroImage(HeroImage $hero)
    {
        $old = $hero->toArray();

        if ($hero->image) {
            $this->deleteFromCloudinary($hero->image);
        }

        $hero->delete();

        AuditService::log('deleted', $hero, [
            'deleted_fields' => $old,
        ]);

        return redirect()->route('hero.create')->with('success', 'Record deleted successfully!');
    }

    // ---- Cloudinary Delete Helper ----
    private function deleteFromCloudinary(string $url): void
    {
        try {
            // Extract public_id from Cloudinary URL
            // URL format: https://res.cloudinary.com/cloud/image/upload/v123456/imageUpload/filename.jpg
            $pattern = '/\/image\/upload\/(?:v\d+\/)?(.+)\.[a-z]+$/i';
            if (preg_match($pattern, $url, $matches)) {
                Cloudinary::destroy($matches[1]);
            }
        } catch (\Exception $e) {
            // Silently fail — don't block the main operation if delete fails
        }
    }
}
