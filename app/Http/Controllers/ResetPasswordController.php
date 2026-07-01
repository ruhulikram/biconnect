<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * Show the reset password form.
     */
    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email', ''),
        ]);
    }

    /**
     * Reset the password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'token'    => ['required'],
                'email'    => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'confirmed'],
            ],
            [
                'token.required'       => 'Token tidak valid.',
                'email.required'       => 'Email wajib diisi.',
                'email.email'          => 'Format email tidak valid.',
                'password.required'    => 'Password wajib diisi.',
                'password.min'         => 'Password minimal 8 karakter.',
                'password.regex'       => 'Password harus mengandung huruf besar dan angka.',
                'password.confirmed'   => 'Konfirmasi password tidak cocok.',
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset! Silakan masuk dengan password baru.')
            : back()->withErrors(['email' => 'Token reset tidak valid atau sudah kedaluwarsa.']);
    }
}
