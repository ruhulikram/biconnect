@extends('layouts.auth')
@section('title', 'Buat Password')

@section('content')
<div class="space-y-6" x-data="{
    password: '',
    confirm: '',
    showPassword: false,
    showConfirm: false,

    get hasMinLength()  { return this.password.length >= 8; },
    get hasUppercase()  { return /[A-Z]/.test(this.password); },
    get hasNumber()     { return /[0-9]/.test(this.password); },
    get passwordsMatch(){ return this.password !== '' && this.password === this.confirm; },
    get allValid()      { return this.hasMinLength && this.hasUppercase && this.hasNumber && this.passwordsMatch; },

    get strengthPercent() {
        let score = 0;
        if (this.hasMinLength)  score += 33;
        if (this.hasUppercase)  score += 33;
        if (this.hasNumber)     score += 34;
        return score;
    },
    get strengthColor() {
        if (this.strengthPercent <= 33) return 'bg-red-500';
        if (this.strengthPercent <= 66) return 'bg-yellow-500';
        return 'bg-green-500';
    },
    get strengthLabel() {
        if (this.password === '') return '';
        if (this.strengthPercent <= 33) return 'Lemah';
        if (this.strengthPercent <= 66) return 'Cukup';
        return 'Kuat';
    }
}">

    {{-- Logo --}}
    <div class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" class="h-10 w-auto">
    </div>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Buat Password</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Buat password yang kuat untuk akunmu.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('auth.save-password') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Password --}}
        <div class="space-y-1.5">
            <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </span>
                <input
                    id="password"
                    name="password"
                    :type="showPassword ? 'text' : 'password'"
                    x-model="password"
                    placeholder="Minimal 8 karakter"
                    required
                    class="w-full h-12 rounded-input border bg-white pl-10 pr-10 py-3 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus
                           {{ $errors->has('password') ? 'border-red-500' : 'border-border' }}">
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg x-show="!showPassword" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg x-show="showPassword" x-cloak class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>

            {{-- Strength bar --}}
            <div x-show="password.length > 0" x-cloak class="space-y-2">
                <div class="flex items-center gap-2">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300"
                             :class="strengthColor"
                             :style="'width: ' + strengthPercent + '%'"></div>
                    </div>
                    <span class="text-xs font-medium" :class="{
                        'text-red-500': strengthPercent <= 33,
                        'text-yellow-600': strengthPercent > 33 && strengthPercent <= 66,
                        'text-green-600': strengthPercent > 66
                    }" x-text="strengthLabel"></span>
                </div>

                {{-- Checklist --}}
                <ul class="space-y-1">
                    <li class="flex items-center gap-2 text-xs" :class="hasMinLength ? 'text-green-600' : 'text-gray-400'">
                        <svg x-show="hasMinLength" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                        <svg x-show="!hasMinLength" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                        Minimal 8 karakter
                    </li>
                    <li class="flex items-center gap-2 text-xs" :class="hasUppercase ? 'text-green-600' : 'text-gray-400'">
                        <svg x-show="hasUppercase" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                        <svg x-show="!hasUppercase" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                        Mengandung huruf besar (A-Z)
                    </li>
                    <li class="flex items-center gap-2 text-xs" :class="hasNumber ? 'text-green-600' : 'text-gray-400'">
                        <svg x-show="hasNumber" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                        <svg x-show="!hasNumber" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                        Mengandung angka (0-9)
                    </li>
                </ul>
            </div>

            @if($errors->has('password'))
                <p class="text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        {{-- Confirm Password --}}
        <div class="space-y-1.5">
            <label for="password_confirmation" class="block text-xs font-medium text-gray-700">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                </span>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    x-model="confirm"
                    placeholder="Ulangi password"
                    required
                    class="w-full h-12 rounded-input border border-border bg-white pl-10 pr-10 py-3 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus">
                <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg x-show="!showConfirm" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg x-show="showConfirm" x-cloak class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>
            <p x-show="confirm.length > 0 && !passwordsMatch" x-cloak class="text-xs text-red-500 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                Password tidak cocok.
            </p>
            <p x-show="passwordsMatch" x-cloak class="text-xs text-green-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                Password cocok!
            </p>
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            :disabled="!allValid"
            class="w-full h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                   hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20
                   disabled:opacity-40 disabled:cursor-not-allowed">
            Buat Akun
        </button>
    </form>
</div>
@endsection
