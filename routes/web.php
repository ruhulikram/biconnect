<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\InfoHubController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// ─── Auth Routes (Guest only) ────────────────────────────────
Route::middleware('guest')->group(function () {
    // Aktivasi
    Route::get('/aktivasi', [AuthController::class, 'showActivate'])->name('auth.activate');
    Route::post('/aktivasi/otp', [AuthController::class, 'sendOtp'])->name('auth.send-otp');

    // OTP Verification
    Route::get('/verifikasi-otp', [AuthController::class, 'showOtp'])->name('auth.otp');
    Route::post('/verifikasi-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');

    // Create Password
    Route::get('/buat-password', [AuthController::class, 'showCreatePassword'])->name('auth.create-password');
    Route::post('/buat-password', [AuthController::class, 'createPassword'])->name('auth.save-password');

    // Login
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('auth.do-login');

    // Email Verification
    Route::get('/verifikasi-email', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/verifikasi-email/{token}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verifikasi-email/kirim-ulang', [EmailVerificationController::class, 'resend'])->name('verification.resend');

    // Forgot / Reset Password
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// ─── Logout (Auth only) ──────────────────────────────────────
Route::post('/keluar', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

// ─── Onboarding Routes (Auth only, NO onboarding middleware) ───
Route::middleware('auth')->prefix('onboarding')->group(function () {
    Route::get('/profil',  [OnboardingController::class, 'stepProfile'])->name('onboarding.profile');
    Route::post('/profil', [OnboardingController::class, 'saveProfile'])->name('onboarding.save-profile');
    Route::get('/skill',   [OnboardingController::class, 'stepSkills'])->name('onboarding.skills');
    Route::post('/skill',  [OnboardingController::class, 'saveSkills'])->name('onboarding.save-skills');
    Route::post('/skip',   [OnboardingController::class, 'skip'])->name('onboarding.skip');
});

// ─── Authenticated Routes (Requires Onboarding) ──────────────
Route::middleware(['auth', 'onboarding'])->group(function () {
    // Feed
    Route::get('/feed', [FeedController::class, 'index'])
        ->name('feed.index');

    // Post CRUD
    Route::get('/post/buat', [PostController::class, 'create'])
        ->name('post.create');
    Route::post('/post', [PostController::class, 'store'])
        ->name('post.store');
    Route::get('/post/{post}', [PostController::class, 'show'])
        ->name('post.show');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])
        ->name('post.destroy');

    // Post Interactions
    Route::post('/post/{post}/tertarik', [PostController::class, 'storeInterest'])
        ->name('interest.store');
    Route::post('/post/{post}/tertarik/{interest}/pilih', [PostController::class, 'selectInterest'])
        ->name('interest.select');
    Route::post('/post/{post}/like', [LikeController::class, 'toggle'])
        ->name('post.like');
    Route::post('/post/{post}/tutup', [PostController::class, 'close'])
        ->name('post.close');
    Route::post('/post/{post}/komentar', [PostController::class, 'storeComment'])
        ->name('post.comment');


    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show.user');
    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');

    // Notifications
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/baca-semua', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');

    // Settings
    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/dark-mode', [SettingsController::class, 'updateDarkMode'])->name('settings.dark-mode');

    // Search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
});

// ─── Admin Routes (Auth & Admin only) ─────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/pengguna', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/pengguna/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.toggle-user');

    // Project Approval
    Route::get('/projects', [AdminController::class, 'pendingProjects'])->name('admin.projects');
    Route::post('/projects/{post}/approve', [AdminController::class, 'approveProject'])->name('admin.approve-project');
    Route::post('/projects/{post}/reject', [AdminController::class, 'rejectProject'])->name('admin.reject-project');

    // All Posts Management
    Route::get('/posts', [AdminController::class, 'allPosts'])->name('admin.posts');

    // Informasi Kampus (Info Hub)
    Route::get('/informasi-kampus', [AdminController::class, 'infoKampus'])->name('admin.info-kampus');

    // Info Hub poster management
    Route::post('/info-hub', [InfoHubController::class, 'store'])->name('admin.info-hub.store');
    Route::put('/info-hub/{infoHub}', [InfoHubController::class, 'update'])->name('admin.info-hub.update');
    Route::delete('/info-hub/{infoHub}', [InfoHubController::class, 'destroy'])->name('admin.info-hub.destroy');
    Route::post('/info-hub/{infoHub}/toggle', [InfoHubController::class, 'toggleActive'])->name('admin.info-hub.toggle');
});
