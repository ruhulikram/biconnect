@extends('layouts.auth')
@section('title', 'Verifikasi Email')

@section('content')
<div class="space-y-6 text-center">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" class="h-10 w-auto">
    </a>

    {{-- Icon --}}
    <div class="flex justify-center">
        <div class="w-16 h-16 bg-primary-light/20 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
        </div>
    </div>

    {{-- Heading --}}
    <div>
        <h1 class="text-2xl font-bold font-heading text-gray-900">Cek Email Kamu</h1>
        <p class="text-sm text-gray-500 mt-1.5 max-w-xs mx-auto">
            Kami telah mengirimkan tautan verifikasi ke:
        </p>
        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $email }}</p>
    </div>

    {{-- Instructions --}}
    <div class="bg-amber-50 border border-amber-200 rounded-card p-4 text-left">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-amber-800">Penting!</p>
                <ul class="mt-1 text-xs text-amber-700 space-y-1">
                    <li>• Klik tautan verifikasi di email untuk mengaktifkan akun.</li>
                    <li>• Tautan berlaku selama <strong>24 jam</strong>.</li>
                    <li>• Periksa folder <strong>Spam</strong> jika email tidak muncul dalam 5 menit.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="space-y-3">
        <form action="{{ route('verification.resend') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-primary hover:text-primary-dark transition-colors font-medium">
                Kirim ulang email verifikasi
            </button>
        </form>

        <p class="text-xs text-gray-400">
            Sudah verifikasi?
            <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark transition-colors font-medium">
                Masuk di sini
            </a>
        </p>
    </div>

</div>
@endsection
