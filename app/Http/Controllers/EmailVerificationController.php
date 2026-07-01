<?php

namespace App\Http\Controllers;

use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Show the "check your email" notice page.
     */
    public function notice(): View|RedirectResponse
    {
        if (! session('pending_verification_email')) {
            return redirect()->route('auth.activate');
        }

        $email = session('pending_verification_email');

        return view('auth.verify-email', compact('email'));
    }

    /**
     * Handle the email verification link.
     */
    public function verify(string $token): RedirectResponse
    {
        $verificationToken = EmailVerificationToken::where('token', $token)
            ->valid()
            ->first();

        if (! $verificationToken) {
            return redirect()->route('login')
                ->with('error', 'Tautan verifikasi tidak valid atau sudah kedaluwarsa. Silakan daftar ulang.');
        }

        // Mark token as used
        $verificationToken->update(['used_at' => now()]);

        // Verify the user
        $user = User::where('email', $verificationToken->email)->first();

        if ($user) {
            $user->update([
                'is_verified'       => true,
                'email_verified_at' => now(),
            ]);
        }

        // Clear session
        session()->forget('pending_verification_email');

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan masuk dengan akun kamu.');
    }

    /**
     * Resend the verification email.
     */
    public function resend(Request $request): RedirectResponse
    {
        $email = session('pending_verification_email');

        if (! $email) {
            return redirect()->route('auth.activate');
        }

        // Invalidate old tokens for this email
        EmailVerificationToken::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Generate new token
        $token = Str::random(64);

        EmailVerificationToken::create([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => now()->addHours(24),
        ]);

        // Send verification email
        \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\EmailVerificationMail($token));

        return back()->with('success', 'Email verifikasi baru telah dikirim ke ' . $email);
    }
}
