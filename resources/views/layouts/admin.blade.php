<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — BiConnect Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-body text-gray-950 antialiased dark:bg-gray-950 dark:text-gray-100" x-data="{ mobileSidebarOpen: false }">

    {{-- Dark Sidebar for Desktop --}}
    <aside class="fixed top-0 bottom-0 left-0 z-30 w-60 bg-[#0F1117] text-gray-300 transition-transform -translate-x-full md:translate-x-0 flex flex-col justify-between"
           :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div>
            {{-- Header/Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-7 w-auto brightness-0 invert">
                    <span class="text-xs uppercase tracking-widest font-heading font-semibold text-primary/80 bg-primary/10 px-2 py-0.5 rounded border border-primary/20">Admin</span>
                </a>
            </div>

            {{-- Navigation Links --}}
            <nav class="mt-6 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-md transition-all duration-150
                          {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 border-l-4 border-primary text-white font-semibold' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-md transition-all duration-150
                          {{ request()->routeIs('admin.users') ? 'bg-primary/10 border-l-4 border-primary text-white font-semibold' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 21m-5.02-2.13A9.232 9.232 0 010 18c0-1.293.761-2.41 1.876-2.913a4.125 4.125 0 017.577 0.095c.23.076.452.174.663.295m-5.122-.08A9.03 9.03 0 0110 15c1.478 0 2.868.355 4.086 1.002M7.5 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm14 0a3.001 3.001 0 11-6 0 3.001 3.001 0 016 0zm-7.375 7.375a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    Manajemen User
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-md transition-all duration-150 text-gray-400 hover:bg-gray-800/50 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z"/>
                    </svg>
                    Postingan
                </a>

                @php
                    $pendingReportsCount = \App\Models\Report::pending()->count();
                @endphp
                <a href="{{ route('admin.reports') }}"
                   class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-md transition-all duration-150
                          {{ request()->routeIs('admin.reports') ? 'bg-primary/10 border-l-4 border-primary text-white font-semibold' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        Laporan
                    </div>
                    @if($pendingReportsCount > 0)
                        <span class="bg-amber-500 text-white font-bold text-xs px-2 py-0.5 rounded-full">
                            {{ $pendingReportsCount }}
                        </span>
                    @endif
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-md transition-all duration-150 text-gray-400 hover:bg-gray-800/50 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        {{-- Footer / User Info --}}
        <div class="p-4 border-t border-gray-800">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">Administrator</p>
                </div>
                {{-- Logout Button --}}
                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1.5 rounded hover:bg-gray-800 text-gray-400 hover:text-white" title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile Sidebar Backdrop --}}
    <div class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm md:hidden"
         x-show="mobileSidebarOpen"
         @click="mobileSidebarOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Main Wrapper --}}
    <div class="md:ml-60 min-h-screen flex flex-col">

        {{-- Top Navbar --}}
        <header class="h-16 bg-white border-b border-border dark:bg-gray-900 dark:border-gray-800 flex items-center justify-between px-6 sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 md:hidden text-gray-500"
                        @click="mobileSidebarOpen = !mobileSidebarOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
                <h2 class="text-lg font-bold font-heading text-gray-900 dark:text-white hidden md:block">@yield('page_title', 'Dashboard')</h2>
                <div class="md:hidden flex items-center gap-2">
                    <span class="text-xs uppercase tracking-widest font-heading font-semibold text-primary bg-primary-light px-2 py-0.5 rounded border border-primary/20">Admin</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- User Dropdown / Initial Avatar --}}
                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                    <img src="{{ auth()->user()->avatar_url }}" alt="Profile" class="w-9 h-9 rounded-full object-cover border-2 border-primary/20">
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
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 max-w-sm bg-white dark:bg-gray-800 border-l-4 border-emerald-500 shadow-lg rounded-md p-4 z-50 flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sukses</p>
                <p class="text-sm text-gray-800 dark:text-gray-200 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 max-w-sm bg-white dark:bg-gray-800 border-l-4 border-red-500 shadow-lg rounded-md p-4 z-50 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kesalahan</p>
                <p class="text-sm text-gray-800 dark:text-gray-200 mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
