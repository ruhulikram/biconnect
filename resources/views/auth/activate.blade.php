@extends('layouts.auth')
@section('title', 'Aktivasi Akun')

@section('content')
<div class="space-y-6" x-data="{
    email: '{{ old('email', '') }}',
    get isValidDomain() {
        return /^[a-zA-Z0-9._%+-]+@bsi\.ac\.id$/.test(this.email);
    }
}">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" width="160" height="40" class="h-10 w-auto">
    </a>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Aktivasi Akun Kamu</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Masukkan email kampus BSI untuk memulai.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('auth.send-otp') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Email Input --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-medium text-gray-700">Email Kampus</label>
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
                    x-model="email"
                    placeholder="nama@bsi.ac.id"
                    required
                    class="w-full h-12 rounded-input border bg-white pl-10 pr-4 py-3 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus
                           {{ $errors->has('email') ? 'border-red-500' : 'border-border' }}">

                {{-- Validation indicator --}}
                <span class="absolute right-3 top-1/2 -translate-y-1/2" x-show="email.length > 0" x-cloak>
                    <svg x-show="isValidDomain" class="w-4.5 h-4.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="!isValidDomain" class="w-4.5 h-4.5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </span>
            </div>

            @if($errors->has('email'))
                <p class="text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('email') }}
                </p>
            @else
                <p class="text-xs text-gray-400" x-show="!isValidDomain && email.length > 3">
                    Hanya email @bsi.ac.id yang diizinkan.
                </p>
            @endif
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            :disabled="!isValidDomain"
            class="w-full h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                   hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20
                   disabled:opacity-40 disabled:cursor-not-allowed">
            Kirim Kode OTP
        </button>
    </form>

    {{-- Footer link --}}
    <p class="text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-primary-dark transition-colors">
            Masuk di sini
        </a>
    </p>
</div>
@endsection
