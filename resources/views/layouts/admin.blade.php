<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->dark_mode ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — BiConnect Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface font-body text-gray-950 antialiased dark:bg-gray-950 dark:text-gray-100"
    x-data="{ mobileSidebarOpen: false }">    {{-- Modern Light Sidebar for Desktop --}}
    <aside
        class="fixed top-0 bottom-0 left-0 z-30 w-60 bg-white dark:bg-slate-900 text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-slate-800/80 transition-transform -translate-x-full md:translate-x-0 flex flex-col justify-between"
        :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div>
            {{-- Header/Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-150 dark:border-slate-800/80">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect"
                        class="h-7 w-auto">
                    <span
                        class="text-[10px] uppercase tracking-widest font-heading font-semibold text-primary dark:text-primary-light bg-primary-light dark:bg-primary/20 px-2 py-0.5 rounded border border-primary/20">Admin</span>
                </a>
            </div>            {{-- Navigation Links --}}
            <nav class="mt-6 px-3 space-y-1">
                {{-- Back to Feed --}}
                <a href="{{ route('feed.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100 transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Kembali ke Feed
                </a>
                <div class="border-t border-gray-150 dark:border-slate-800/80 my-2"></div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-950 dark:bg-slate-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100' }}">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('admin.users') ? 'bg-gray-100 text-gray-950 dark:bg-slate-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100' }}">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 21m-5.02-2.13A9.232 9.232 0 010 18c0-1.293.761-2.41 1.876-2.913a4.125 4.125 0 017.577 0.095c.23.076.452.174.663.295m-5.122-.08A9.03 9.03 0 0110 15c1.478 0 2.868.355 4.086 1.002M7.5 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm14 0a3.001 3.001 0 11-6 0 3.001 3.001 0 016 0zm-7.375 7.375a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Manajemen Pengguna
                </a>

                @php
                    $pendingProjectsCount = \App\Models\Post::where('type', 'project')
                        ->where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.projects') }}"
                    class="flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('admin.projects') ? 'bg-gray-100 text-gray-950 dark:bg-slate-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z" />
                        </svg>
                        Project Pending
                    </div>
                    @if($pendingProjectsCount > 0)
                        <span class="bg-amber-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full shadow-sm">
                            {{ $pendingProjectsCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.posts') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('admin.posts') ? 'bg-gray-100 text-gray-950 dark:bg-slate-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100' }}">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z" />
                    </svg>
                    Semua Postingan
                </a>

                <a href="{{ route('admin.info-kampus') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('admin.info-kampus') ? 'bg-gray-100 text-gray-950 dark:bg-slate-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:text-gray-900 dark:hover:text-slate-100' }}">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                    Informasi Kampus
                </a>
            </nav>
        </div>

        {{-- Footer / User Info --}}
        <div class="p-4 border-t border-gray-150 dark:border-slate-800/80 bg-gray-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-3">
                <x-ui.avatar :src="auth()->user()->avatar_url" size="sm" />
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">Administrator</p>
                </div>
                {{-- Logout Button --}}
                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-400 hover:text-red-500 transition-colors"
                        title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile Sidebar Backdrop --}}
    <div class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm md:hidden" x-show="mobileSidebarOpen"
        @click="mobileSidebarOpen = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
    </div>

    {{-- Main Wrapper --}}
    <div class="md:ml-60 min-h-screen flex flex-col">

        {{-- Top Navbar --}}
        <header
            class="h-16 bg-white border-b border-border dark:bg-gray-900 dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 md:hidden text-gray-500"
                    @click="mobileSidebarOpen = !mobileSidebarOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-white hidden md:block">
                    @yield('page_title', 'Dashboard')</h2>
                <div class="md:hidden flex items-center gap-2">
                    <span
                        class="text-xs uppercase tracking-widest font-heading font-semibold text-primary bg-primary-light px-2 py-0.5 rounded border border-primary/20">Admin</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- User Dropdown / Initial Avatar --}}
                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                    <x-ui.avatar :src="auth()->user()->avatar_url" size="sm" class="border border-gray-250 dark:border-slate-800/80" />
                </div>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="flex-1 p-6 bg-surface dark:bg-gray-950">
            @yield('content')
        </main>

    </div>

    {{-- Toast Notifications --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4500)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed bottom-6 right-6 max-w-sm bg-white dark:bg-slate-900 border border-emerald-500/20 dark:border-emerald-500/30 shadow-xl rounded-2xl p-4.5 z-50 flex items-start gap-4">
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

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed bottom-6 right-6 max-w-sm bg-white dark:bg-slate-900 border border-red-500/20 dark:border-red-500/30 shadow-xl rounded-2xl p-4.5 z-50 flex items-start gap-4">
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

    @stack('scripts')
</body>

</html>