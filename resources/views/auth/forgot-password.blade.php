@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<div class="space-y-6">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-10 w-auto">
    </a>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Lupa Password?</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Masukkan email kampus BSI kamu. Kami akan mengirimkan tautan untuk mereset password.
        </p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-card p-4 text-center">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                Email Kampus
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="nama@bsi.ac.id"
                    class="w-full h-12 pl-10 pr-4 rounded-input border text-sm bg-white border-gray-300 placeholder:text-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('email') border-danger @enderror"
                >
            </div>
            @error('email')
                <div class="mt-1.5 flex items-center gap-1 text-xs text-danger">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full h-12 rounded-input bg-primary text-white font-semibold text-sm hover:bg-primary-dark transition-colors active:scale-[0.98]">
            Kirim Tautan Reset
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="bg-white px-3 text-gray-400">atau</span>
        </div>
    </div>

    {{-- Back to login --}}
    <p class="text-sm text-gray-500 text-center">
        Ingat password kamu?
        <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark transition-colors font-medium">
            Masuk di sini
        </a>
    </p>

</div>
@endsection
