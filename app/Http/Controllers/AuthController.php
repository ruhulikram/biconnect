<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ─── Aktivasi ────────────────────────────────────────────

    public function showActivate(): View
    {
        return view('auth.activate');
    }

    public function sendOtp(SendOtpRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];

        // Prevent account hijack: block already verified & active users
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->is_verified) {
            return back()->withErrors([
                'email' => 'Email sudah terdaftar dan aktif. Silakan masuk atau gunakan fitur lupa password.',
            ])->onlyInput('email');
        }

        // Invalidate previous OTPs for this email
        OtpVerification::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Generate 6-digit OTP
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'code'       => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Send OTP via email (log driver for development)
        Mail::raw("Kode OTP BiConnect kamu: {$code}\n\nKode ini berlaku selama 5 menit.", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Kode OTP BiConnect');
        });

        // Store email in session for OTP page
        session(['otp_email' => $email]);

        return redirect()
            ->route('auth.otp')
            ->with('success', 'Kode OTP telah dikirim ke ' . $email);
    }

    // ─── Verifikasi OTP ──────────────────────────────────────

    public function showOtp(): View|RedirectResponse
    {
        if (! session('otp_email')) {
            return redirect()->route('auth.activate');
        }

        return view('auth.otp', [
            'email' => session('otp_email'),
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $otp = OtpVerification::where('email', $validated['email'])
            ->where('code', $validated['code'])
            ->whereNull('used_at')
            ->latest('created_at')
            ->first();

        if (! $otp) {
            return back()->withErrors([
                'code' => 'Kode OTP tidak valid.',
            ]);
        }

        if ($otp->expires_at->isPast()) {
            return back()->withErrors([
                'code' => 'Kode OTP sudah kedaluwarsa.',
            ]);
        }

        // Mark OTP as used
        $otp->update(['used_at' => now()]);

        // Create user if not exists (email verification happens after password creation)
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name'        => explode('@', $validated['email'])[0],
                'password'    => bcrypt(str()->random(32)), // temporary password
                'is_verified' => false,
            ]
        );

        // Store user ID in session for password creation
        session(['verified_user_id' => $user->id]);

        return redirect()->route('auth.create-password');
    }

    // ─── Buat Password ───────────────────────────────────────

    public function showCreatePassword(): View|RedirectResponse
    {
        if (! session('verified_user_id')) {
            return redirect()->route('auth.activate');
        }

        return view('auth.create-password');
    }

    public function createPassword(CreatePasswordRequest $request): RedirectResponse
    {
        $userId = session('verified_user_id');

        if (! $userId) {
            return redirect()->route('auth.activate');
        }

        $user = User::findOrFail($userId);
        $user->update([
            'password' => bcrypt($request->validated()['password']),
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Clear session data
        session()->forget(['otp_email', 'verified_user_id']);

        // Log the user in immediately
        Auth::login($user);

        return redirect()->route('feed.index')
            ->with('success', 'Akun berhasil diaktifkan! Selamat datang di BiConnect.');
    }

    // ─── Login ───────────────────────────────────────────────

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        if (! Auth::user()->is_verified) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Store email for resend option & redirect to verification notice page
            session(['pending_verification_email' => $credentials['email']]);

            return redirect()->route('verification.notice')
                ->with('warning', 'Akun kamu belum diverifikasi. Silakan cek email untuk tautan verifikasi.');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'email' => 'Akun kamu telah dinonaktifkan oleh Administrator.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Check if profile is incomplete → send one-time notification
        $user = Auth::user();
        if (!$user->onboarding_completed) {
            return redirect()->route('onboarding.profile');
        }

        // Send profile completion reminder if bio or skills are missing (only once)
        $user->sendProfileCompletionReminder();

        return redirect()->intended(route('feed.index'))
            ->with('success', 'Selamat datang kembali!');
    }

    // ─── Logout ──────────────────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu telah logout.');
    }
}
