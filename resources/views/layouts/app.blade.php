<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BiConnect') — Platform Kolaborasi Mahasiswa BSI</title>
    <meta name="description" content="@yield('meta_description', 'BiConnect adalah platform kolaborasi project dan diskusi untuk mahasiswa Universitas Bina Sarana Informatika.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-body text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100 transition-colors">

    {{-- Sticky Top Navbar --}}
    @include('components.navbar')

    {{-- Main Content --}}
    <main class="min-h-screen pb-20 md:pb-0">
        @yield('content')
    </main>

    {{-- Footer (Desktop only) --}}
    <div class="hidden md:block">
        @include('components.footer')
    </div>

    {{-- Bottom Nav (Mobile only) --}}
    <div class="block md:hidden">
        @include('components.bottom-nav')
    </div>

    {{-- Toast: Success --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 md:translate-x-4 md:translate-y-0"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-2 md:translate-x-4"
             class="fixed bottom-24 md:bottom-8 right-4 md:right-8 left-4 md:left-auto max-w-sm bg-white dark:bg-gray-800 border-l-4 border-emerald-500 shadow-lg rounded-lg p-4 z-50 flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sukses</p>
                <p class="text-sm text-gray-800 dark:text-gray-200 mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Toast: Error --}}
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 md:translate-x-4 md:translate-y-0"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-2 md:translate-x-4"
             class="fixed bottom-24 md:bottom-8 right-4 md:right-8 left-4 md:left-auto max-w-sm bg-white dark:bg-gray-800 border-l-4 border-red-500 shadow-lg rounded-lg p-4 z-50 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kesalahan</p>
                <p class="text-sm text-gray-800 dark:text-gray-200 mt-0.5">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Search Modal --}}
    @include('components.modals.search')

    @stack('scripts')
</body>
</html>
