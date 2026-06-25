@extends('layouts.landing')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center text-center px-6">
    <div class="text-red-500/20 dark:text-red-500/10 mb-6">
        <svg class="w-32 h-32 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
    </div>
    
    <h1 class="text-6xl font-bold font-heading text-gray-900 dark:text-white mb-4">500</h1>
    <h2 class="text-2xl font-bold font-heading text-gray-800 dark:text-gray-200 mb-4">Kesalahan Server Internal</h2>
    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8 leading-relaxed">
        Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang berusaha memperbaikinya.
    </p>
    
    <x-ui.button variant="primary" size="lg" :href="route('feed.index')" class="shadow-lg shadow-primary/20">
        Kembali ke Beranda
    </x-ui.button>
</div>
@endsection
