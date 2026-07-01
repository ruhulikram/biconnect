@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="space-y-6" x-data="{ showPassword: false }">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-10 w-auto">
    </a>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Selamat Datang</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Masuk ke akun BiConnect kamu.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('auth.do-login') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </span>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="nama@bsi.ac.id"
                    required
                    class="w-full h-12 rounded-input border bg-white pl-10 pr-4 py-3 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus
                           {{ $errors->has('email') ? 'border-red-500' : 'border-border' }}">
            </div>
            @if($errors->has('email'))
                <p class="text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('email') }}
                </p>
            @endif
        </div>

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
                    placeholder="Masukkan password"
                    required
                    class="w-full h-12 rounded-input border border-border bg-white pl-10 pr-10 py-3 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus">
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
            @if($errors->has('password'))
                <p class="text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" value="1"
                   class="w-4 h-4 rounded border-border text-primary focus:ring-primary/20">
            <label for="remember" class="text-xs text-gray-600">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="w-full h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                   hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20">
            Masuk
        </button>

        {{-- Forgot password link --}}
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-xs text-primary hover:text-primary-dark transition-colors font-medium">Lupa password?</a>
        </div>
    </form>

    {{-- Divider --}}
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-3 bg-white md:bg-white text-gray-400">atau</span>
        </div>
    </div>

    {{-- Activate link --}}
    <p class="text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('auth.activate') }}" class="text-primary font-medium hover:text-primary-dark transition-colors">
            Aktivasi di sini
        </a>
    </p>
</div>
@endsection
