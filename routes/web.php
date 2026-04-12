<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdministrationYearController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\OthersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TemplateController;
use App\Mail\LasuMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name(name: 'profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name(name: 'profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Mail
Route::get('/testroute', function () {
    $name = 'LASU CNS CHAPTER';
    // The mail sending is done using the Mail facade
    Mail::to('idowu.s.adekale@gmail.com')->send(new LasuMail($name));
});

// Super Admin routes
Route::middleware(['auth', 'role:super'])->prefix('superadmin')->group(function () {
    // Audit Trails Routes
    Route::get('/audit', [AuditTrailController::class, 'index'])->name('audit.index');
    Route::get('/audit/json', [AuditTrailController::class, 'ajaxLogs'])->name('audit.json');
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');
    Route::get('/create', [SuperAdminController::class, 'create'])->name('superadmin.create');
    Route::post('/store', [SuperAdminController::class, 'store'])->name('superadmin.store');
    Route::delete('/delete/{id}', [SuperAdminController::class, 'destroy'])->name('superadmin.destroy');
});

// Developer-only routes (create super admins + dashboard + delete super admins)
Route::middleware(['auth'])->prefix('developer')->group(function () {
    // Developer Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'developerDashboard'])->name('developer.dashboard');

    // Create Super Admin
    Route::get('/createSuper', [SuperAdminController::class, 'createSuper'])->name('developer.createSuper');
    Route::post('/storeSuper', [SuperAdminController::class, 'storeSuper'])->name('developer.storeSuper');

    // Delete Super Admin
    Route::delete('/super-delete/{id}', [SuperAdminController::class, 'destroySuper'])->name('developer.destroy-super');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Ojo Executive Operations
    Route::get('/create-executive', [ExecutiveController::class, 'createEx'])->name('executives.create');
    Route::post('/createPost', [ExecutiveController::class, 'addEntry'])->name('executives.addEntry');
    Route::get('/executives/{executive}/edit', [ExecutiveController::class, 'editEx'])->name('executives.edit');
    Route::put('/executives/{executive}/update', [ExecutiveController::class, 'saveEntry'])->name('executives.update');
    Route::delete('/executives/{executive}/destroy', [ExecutiveController::class, 'destroy'])->name('executives.delete');
    // Other Executive Operations [secretaries]
    Route::get('/executivesOth', [SecretaryController::class, 'createSec'])->name('secretaries.create');
    Route::post('/createOth', [SecretaryController::class, 'addEntry'])->name('secretaries.addEntry');
    Route::get('/executivesOth/{secretary}/edit', [SecretaryController::class, 'editSec'])->name('secretaries.edit');
    Route::put('/executivesOth/{secretary}/update', [SecretaryController::class, 'saveEntry'])->name('secretaries.update');
    Route::delete('/executivesOth/{secretary}/destroy', [SecretaryController::class, 'destroySec'])->name('secretaries.delete');
    // Gallery Operations
    Route::get('gallery/create', [GalleryController::class, 'createGallery'])->name('galleries.create');
    Route::post('gallery/store', [GalleryController::class, 'storeGallery'])->name('galleries.store');
    Route::get('gallery/{gallery}/edit', [GalleryController::class, 'editGallery'])->name('galleries.edit');
    Route::put('gallery/{gallery}', [GalleryController::class, 'updateGallery'])->name('galleries.update');
    Route::delete('/gallery/{gallery}/delete', [GalleryController::class, 'deleteGallery'])->name('galleries.delete');
    // Announcement Operations
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}/delete', [AnnouncementController::class, 'delete'])->name('announcements.delete');
    // Birthday Operations
    Route::get('birthdays/create', [BirthdayController::class, 'create'])->name('birthdays.create');
    Route::post('birthdays/store', [BirthdayController::class, 'store'])->name('birthdays.store');
    Route::get('birthdays/{birthday}/edit', [BirthdayController::class, 'edit'])->name('birthdays.edit');
    Route::put('birthdays/{birthday}', [BirthdayController::class, 'update'])->name('birthdays.update');
    Route::delete('/birthdays/{birthday}/delete', [BirthdayController::class, 'delete'])->name('birthdays.delete');
    // Leader Operations
    Route::get('leaders/create', [LeaderController::class, 'create'])->name('leaders.create');
    Route::post('leaders/store', [LeaderController::class, 'store'])->name('leaders.store');
    Route::get('leaders/{leader}/edit', [LeaderController::class, 'edit'])->name('leaders.edit');
    Route::put('leaders/{leader}', [LeaderController::class, 'update'])->name('leaders.update');
    Route::delete('/leaders/{leader}/delete', [LeaderController::class, 'delete'])->name('leaders.delete');
    // Newsletter Operations
    Route::resource('templates', TemplateController::class);
    Route::get('/createTemp', [TemplateController::class, 'create'])->name('templates.create');
    Route::get('/Newsletter', [TemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates/{template}/send', [TemplateController::class, 'send'])->name('templates.send');
    // Program Operations
    Route::get('/create-program', [ProgramController::class, 'createPro'])->name('programs.create');
    Route::post('/create-programPost', [ProgramController::class, 'addEntry'])->name('programs.addEntry');
    Route::get('/programs/{program}/edit', [ProgramController::class, 'editPro'])->name('programs.edit');
    Route::put('/programs/{program}/update', [ProgramController::class, 'saveEntry'])->name('programs.saveEntry');
    Route::delete('/programs/{program}/destroy', [ProgramController::class, 'destroyPro'])->name('programs.destroy');
    // Activities Operations
    Route::get('/create-activities', [ActivityController::class, 'createAct'])->name('activities.create');
    Route::post('/create-activitiesPost', [ActivityController::class, 'addEntry'])->name('activities.addEntry');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'editAct'])->name('activities.edit');
    Route::put('/activities/{activity}/update', [ActivityController::class, 'saveEntry'])->name('activities.saveEntry');
    Route::delete('/activities/{activity}/destroy', [ActivityController::class, 'destroy'])->name('activities.destroy');
    // Faq Operations
    Route::get('/create-faqs', [FaqController::class, 'createFaq'])->name('faqs.create');
    Route::post('/create-faqPost', [FaqController::class, 'addEntry'])->name('faqs.addEntry');
    Route::get('/faqs/{faq}/edit', [FaqController::class, 'editFaq'])->name('faqs.edit');
    Route::put('/faqs/{faq}/update', [FaqController::class, 'saveEntry'])->name('faqs.saveEntry');
    Route::delete('/faqs/{faq}/destroy', [FaqController::class, 'destroy'])->name('faqs.destroy');
    // Administration Year Operations
    Route::get('/admin-year', [AdministrationYearController::class, 'index'])->name('admin-year.index');
    Route::post('/admin-year', [AdministrationYearController::class, 'storeOrUpdate'])->name('admin-year.storeOrUpdate');
    // SiteContent Operations
    Route::prefix('admin')->group(function () {
        Route::get('social/edit', [SiteContentController::class, 'editSocial'])->name('social.edit');
        Route::post('social/update', [SiteContentController::class, 'updateSocial'])->name('social.update');
        Route::get('landing/edit', [SiteContentController::class, 'editLanding'])->name('landing.edit');
        Route::post('landing/update', [SiteContentController::class, 'updateLanding'])->name('landing.update');
        Route::get('team/create', [SiteContentController::class, 'createTeam'])->name('team.create');
        Route::post('team/store', [SiteContentController::class, 'storeTeam'])->name('team.store');
        Route::get('team/{team}/edit', [SiteContentController::class, 'editTeam'])->name('team.edit');
        Route::put('team/{team}', [SiteContentController::class, 'updateTeam'])->name('team.update');
        Route::delete('/team/{team}/delete', [SiteContentController::class, 'deleteTeam'])->name('team.delete');
        Route::get('images/create', [SiteContentController::class, 'createImage'])->name('images.create');
        Route::post('images/store', [SiteContentController::class, 'storeImage'])->name('images.store');
        Route::get('images/{group}/edit', [SiteContentController::class, 'editImage'])->name('images.edit');
        Route::put('images/{group}', [SiteContentController::class, 'updateImage'])->name('images.update');
        Route::delete('/images/{group}/delete', [SiteContentController::class, 'deleteImage'])->name('images.delete');
        Route::get('hero/create', [SiteContentController::class, 'createHeroImage'])->name('hero.create');
        Route::post('hero/store', [SiteContentController::class, 'storeHeroImage'])->name('hero.store');
        Route::delete('/hero/{hero}/delete', [SiteContentController::class, 'deleteHeroImage'])->name('hero.delete');
    });
});

// Landing Page Content Management Routes
// HomePage
Route::get('/', [OthersController::class, 'welcome'])->name('welcome');
// About Us
Route::get('/aboutus', [OthersController::class, 'aboutus'])->name('aboutus');
// Contact
Route::get('/contact', [OthersController::class, 'contactus'])->name('contact');
Route::post('/contact/send', [OthersController::class, 'sendContact'])->name('contact.send');
// Subscribe
Route::post('/subscribe', [OthersController::class, 'subscribe'])->name('subscribe');
Route::get('/unsubscribe/{email}', [OthersController::class, 'unsubscribe'])->name('unsubscribe');
// Executive
Route::get('/executives', [ExecutiveController::class, 'index'])->name('executives.index');
// Gallery
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
// Program
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/program/{program}', [ProgramController::class, 'showPro'])->name('programs.show');
// Announcement
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('announcements/{announcement}/show', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/leaders', [LeaderController::class, 'index'])->name('leaders.index');

require __DIR__.'/auth.php';
