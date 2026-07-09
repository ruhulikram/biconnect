<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BiConnect') — Platform Kolaborasi Mahasiswa BSI</title>
    <meta name="description" content="@yield('meta_description', 'BiConnect adalah platform kolaborasi project dan diskusi untuk mahasiswa Universitas Bina Sarana Informatika.')">
    
    <!-- Google Fonts Preconnect & Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

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
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 md:translate-x-4 md:translate-y-0"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-2 md:translate-x-4"
             class="fixed bottom-24 md:bottom-8 right-4 md:right-8 left-4 md:left-auto max-w-sm bg-white dark:bg-slate-900 border border-emerald-500/20 dark:border-emerald-500/30 shadow-xl rounded-2xl p-4.5 z-50 flex items-start gap-4">
            <div class="shrink-0 mt-0.5">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-none">SUKSES</p>
                <p class="text-sm text-slate-700 dark:text-slate-200 mt-1.5 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 shrink-0 mt-0.5">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
             class="fixed bottom-24 md:bottom-8 right-4 md:right-8 left-4 md:left-auto max-w-sm bg-white dark:bg-slate-900 border border-red-500/20 dark:border-red-500/30 shadow-xl rounded-2xl p-4.5 z-50 flex items-start gap-4">
            <div class="shrink-0 mt-0.5">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-none">KESALAHAN</p>
                <p class="text-sm text-slate-700 dark:text-slate-200 mt-1.5 leading-relaxed">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 shrink-0 mt-0.5">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
