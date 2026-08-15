<?php

use App\Http\Controllers\Admin\AcademicRecordController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MusicalRecordController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PortfolioController::class, 'landing'])->name('landing');

Route::get('/academic/{section?}', [PortfolioController::class, 'academic'])
    ->where('section', 'bio|research|teaching')
    ->name('academic');

Route::get('/music/{section?}', [PortfolioController::class, 'music'])
    ->where('section', 'band|discography|courses|booking')
    ->name('music');

Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [App\Http\Controllers\Public\SeoController::class, 'sitemap'])
    ->name('sitemap');
Route::get('/robots.txt', [App\Http\Controllers\Public\SeoController::class, 'robots'])
    ->name('robots');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Academic Records CRUD
    Route::resource('academic-records', AcademicRecordController::class)->except(['show']);
    Route::post('/academic-records/{academic_record}/restore', [AcademicRecordController::class, 'restore'])
        ->name('academic-records.restore');
    Route::delete('/academic-records/{academic_record}/force-delete', [AcademicRecordController::class, 'forceDelete'])
        ->name('academic-records.force-delete');

    // Music Records CRUD
    Route::resource('music-records', MusicalRecordController::class)->except(['show']);
    Route::post('/music-records/{musical_record}/restore', [MusicalRecordController::class, 'restore'])
        ->name('music-records.restore');
    Route::delete('/music-records/{musical_record}/force-delete', [MusicalRecordController::class, 'forceDelete'])
        ->name('music-records.force-delete');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Media Upload
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');

    // Trash Bin
    Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');

    // Contact Submissions
    Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
    Route::get('/contact-submissions/{submission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
    Route::delete('/contact-submissions/{submission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');
});

// Auth Routes (Breeze handles these)
require __DIR__.'/auth.php';
