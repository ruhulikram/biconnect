@extends('layouts.landing')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center text-center px-6">
    <div class="text-primary/10 dark:text-primary/5 mb-6">
        <svg class="w-32 h-32 mx-auto" fill="none" stroke="currentColor" stroke-width="0.75" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
        </svg>
    </div>
    
    <h1 class="text-6xl font-bold font-heading text-gray-900 dark:text-white mb-4">404</h1>
    <h2 class="text-2xl font-bold font-heading text-gray-800 dark:text-gray-200 mb-4">Halaman Tidak Ditemukan</h2>
    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8 leading-relaxed">
        Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
    </p>
    
    <x-ui.button variant="primary" size="lg" :href="route('feed.index')" class="shadow-lg shadow-primary/20">
        Kembali ke Beranda
    </x-ui.button>
</div>
@endsection
