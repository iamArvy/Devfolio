<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectController;
// use App\Http\Controllers\CertificationController;


Route::get('/', fn () => redirect()->route('profile.index'));

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::resource('certifications', CertificationController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('profile', ProfileController::class)->only(['index', 'store']);
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('socials', SocialController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('stacks', StackController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('experiences', ExperienceController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('projects', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/client.php';

