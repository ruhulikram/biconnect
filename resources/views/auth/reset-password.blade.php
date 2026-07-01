@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="space-y-6" x-data="{
    password: '',
    confirmation: '',
    get hasMinLength() { return this.password.length >= 8; },
    get hasUppercase() { return /[A-Z]/.test(this.password); },
    get hasNumber() { return /[0-9]/.test(this.password); },
    get passwordsMatch() { return this.password && this.password === this.confirmation; },
    get isValid() { return this.hasMinLength && this.hasUppercase && this.hasNumber && this.passwordsMatch; }
}">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-10 w-auto">
    </a>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Reset Password</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Buat password baru untuk akun kamu.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Hidden fields --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Password Baru
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    x-model="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 karakter, huruf besar & angka"
                    class="w-full h-12 pl-10 pr-4 rounded-input border text-sm bg-white border-gray-300 placeholder:text-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('password') border-danger @enderror"
                >
            </div>
            @error('password')
                <div class="mt-1.5 flex items-center gap-1 text-xs text-danger">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                Konfirmasi Password
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </span>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    x-model="confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    class="w-full h-12 pl-10 pr-4 rounded-input border text-sm bg-white border-gray-300 placeholder:text-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                >
            </div>

            {{-- Password match indicator --}}
            <p x-show="confirmation.length > 0" x-cloak class="mt-1.5 flex items-center gap-1 text-xs" :class="passwordsMatch ? 'text-success' : 'text-danger'">
                <template x-if="passwordsMatch">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                        </svg>
                        Password cocok
                    </span>
                </template>
                <template x-if="!passwordsMatch">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                        </svg>
                        Password tidak cocok
                    </span>
                </template>
            </p>
        </div>

        {{-- Strength Meter --}}
        <div x-show="password.length > 0" x-cloak class="space-y-2">
            <div class="flex gap-1.5">
                <div class="flex-1 h-1.5 rounded-pill transition-colors"
                     :class="hasMinLength ? 'bg-success' : 'bg-gray-200'"></div>
                <div class="flex-1 h-1.5 rounded-pill transition-colors"
                     :class="hasUppercase ? 'bg-success' : 'bg-gray-200'"></div>
                <div class="flex-1 h-1.5 rounded-pill transition-colors"
                     :class="hasNumber ? 'bg-success' : 'bg-gray-200'"></div>
            </div>
            <ul class="text-xs space-y-1 text-gray-500">
                <li class="flex items-center gap-1.5" :class="hasMinLength ? 'text-success' : 'text-gray-400'">
                    <span x-show="hasMinLength">✓</span><span x-show="!hasMinLength">○</span>
                    Minimal 8 karakter
                </li>
                <li class="flex items-center gap-1.5" :class="hasUppercase ? 'text-success' : 'text-gray-400'">
                    <span x-show="hasUppercase">✓</span><span x-show="!hasUppercase">○</span>
                    Mengandung huruf besar (A-Z)
                </li>
                <li class="flex items-center gap-1.5" :class="hasNumber ? 'text-success' : 'text-gray-400'">
                    <span x-show="hasNumber">✓</span><span x-show="!hasNumber">○</span>
                    Mengandung angka (0-9)
                </li>
            </ul>
        </div>

        {{-- Submit --}}
        <button type="submit"
                :disabled="!isValid"
                class="w-full h-12 rounded-input bg-primary text-white font-semibold text-sm hover:bg-primary-dark transition-colors active:scale-[0.98] disabled:opacity-40 disabled:cursor-not-allowed">
            Reset Password
        </button>
    </form>

</div>
@endsection
