<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\NewsletterSubscription;
use App\Models\Activity;
use App\Models\AdministrationYear;
use App\Models\Executive;
use App\Models\Faq;
use App\Models\HeroImage;
use App\Models\Image;
use App\Models\LandingPage;
use App\Models\Program;
use App\Models\SocialMedia;
use App\Models\Subscribe;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OthersController extends Controller
{
    public function welcome()
    {
        // Fetch all images from DB
        $images = HeroImage::pluck('image')->toArray();

        // Fetch President (just one)
        $president = Executive::where('position', 'President')->first();

        // Fetch upcoming programs only, sorted by soonest first, limit 5
        $programs = Program::whereDate('date', '>=', now()->toDateString())
                            ->orderBy('date', 'asc')
                            ->orderBy('time', 'asc')
                            ->limit(5)
                            ->get();
        $nextProgram = Program::whereDate('date', '>=', now()->toDateString())
        ->orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->first(); // Only the nearest one

        $social = SocialMedia::first();
        $landing = LandingPage::first();
        $AdmYear = AdministrationYear::first();

        // ✅ New: Fetch teams & images
        // Priority roles first
        $priorityOrder = [
            'CEC Chairman',
            'GF Chairman',
            'Zonal Supervisor',
            'Assistant Zonal Supervisor',
        ];
        $teams = Team::orderByRaw('
            CASE
                WHEN position = ? THEN 1
                WHEN position = ? THEN 2
                WHEN position = ? THEN 3
                WHEN position = ? THEN 4
                ELSE 5
            END
        ', $priorityOrder)
            ->orderBy('created_at', 'desc')->get();
        // Activities Scheduling first
        $days = [
            'Every Sunday',
            'Every Monday',
            'Every Tuesday',
            'Every Wednessday',
            'Every Thursday',
            'Every Friday',
            'Every Saturday',
        ];

        $caseSql = 'CASE';
        foreach ($days as $index => $day) {
            $caseSql .= ' WHEN day = ? THEN '.($index + 1);
        }
        $caseSql .= ' ELSE 999 END';

        $activities = Activity::orderByRaw($caseSql, $days)
                              ->orderBy('time1', 'asc')       // sort by start time
                              ->orderBy('created_at', 'desc') // newest if same time
                              ->get();
        $galleryImages = Image::all();
        $faqs = Faq::orderBy('title', 'asc')->get();

        return view('welcome', compact(
            'images',
            'president',
            'programs',
            'nextProgram',
            'social',
            'landing',
            'AdmYear',
            'teams',
            'galleryImages',
            'faqs',
            'activities'
        ));
    }

    // Show the about page
    public function aboutus()
    {
        return view('aboutus');
    }

    // Show the contact form
    public function contactus()
    {
        $landing = LandingPage::first();

        return view('contact', compact('landing'));
    }

    public function sendContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Fetch landing settings
        $landing = LandingPage::first();

        // Receiver logic
        $receiver = $landing && !empty($landing->mail)
            ? $landing->mail
            : config('app.mail');

        Mail::to($receiver)->send(new ContactMail($data));

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // Show the admin access
    public function access()
    {
        return view('access');
    }

    // Handle subscription
    public function subscribe(Request $request)
    {
        try {
            // Validate email with custom messages
            $validated = $request->validate([
                'email' => 'required|email|unique:subscribes,email',
            ], [
                'email.required' => 'Please provide your email address.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email is already subscribed to our newsletter.',
            ]);

            // Create subscriber and send welcome email
            $subscriber = Subscribe::create($validated);
            Mail::to($subscriber->email)->send(new NewsletterSubscription($subscriber->email));

            return back()->with('success', 'Thank you for subscribing! You will now receive updates and communications from LASU CNS CHAPTER. God bless you.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error("Subscription error: {$e->getMessage()}");

            return back()->with('error', 'Sorry, something went wrong. Please try again later.');
        }
        //     catch (\Exception $e) {
        //     dd($e->getMessage()); // Shows the actual error message on the screen
        // }
    }

    // Optional: Add unsubscribe method
    public function unsubscribe($email)
    {
        try {
            $subscriber = Subscribe::where('email', $email)->first();

            if ($subscriber) {
                $subscriber->delete();

                return view('mail.unsubscribed')->with('email', $email);
            }

            return redirect('/')->with('error', 'Email address not found in our subscription list.');
        } catch (\Exception $e) {
            Log::error('Unsubscription error: '.$e->getMessage());

            return redirect('/')->with('error', 'Sorry, we encountered an issue unsubscribing your email.');
        }
    }
}
