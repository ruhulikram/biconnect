<nav class="sticky top-0 z-40 bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-slate-800 h-14 flex items-center transition-colors">
    <div class="w-full max-w-6xl mx-auto px-4 md:px-6 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('feed.index') }}" class="flex items-center shrink-0">
            <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-8 w-auto">
        </a>

        <!--{{-- Desktop nav links --}}
        <div class="hidden md:flex items-center gap-1.5">
            <a href="{{ route('feed.index') }}"
               class="px-3.5 py-1.5 rounded-input text-sm font-semibold transition-all duration-150
                      {{ request()->routeIs('feed.*') && request('type') !== 'project' ? 'text-primary bg-primary-light dark:bg-primary/10 dark:text-primary-light' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800/60' }}">
                Feed
            </a>
            <a href="{{ route('feed.index') }}?type=project"
               class="px-3.5 py-1.5 rounded-input text-sm font-semibold transition-all duration-150
                      {{ request('type') === 'project' ? 'text-primary bg-primary-light dark:bg-primary/10 dark:text-primary-light' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800/60' }}">
                Project
            </a>
        </div>-->

        {{-- Right actions --}}
        <div class="flex items-center gap-1.5">

            {{-- Search --}}
            <button id="nav-search-btn" @click="$dispatch('open-search')"
                    class="p-2 rounded-input hover:bg-gray-50 text-gray-500 transition-colors dark:hover:bg-slate-800 dark:text-slate-400" aria-label="Cari" title="Cari (Ctrl+K)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </button>

            {{-- Notifications --}}
            <a href="{{ route('notifications.index') }}" id="nav-notifications-btn"
               class="relative p-2 rounded-input hover:bg-gray-50 text-gray-500 transition-colors dark:hover:bg-slate-800 dark:text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
                @if(auth()->user()?->unreadNotifications->count() > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
                @endif
            </a>

            {{-- Gear icon dengan dropdown --}}
            <div class="relative" x-data="navSettingsDropdown()">

                {{-- Trigger button --}}
                <button @click="open = !open"
                        @click.outside="open = false"
                        id="nav-settings-btn"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 dark:text-slate-400 transition-colors
                               {{ request()->routeIs('settings.*') ? 'text-primary bg-primary-light dark:bg-primary/10 dark:text-primary-light' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>

                {{-- Dropdown menu --}}
                <div x-show="open"
                     style="display: none;"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 top-full mt-2 w-52 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800
                            rounded-card shadow-lg py-1 z-50">

                    {{-- Dark mode toggle --}}
                    <div class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                        <span class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-200">
                            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0118 15.75 9.75 9.75 0 018.25 6c0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25 9.75 9.75 0 0012.75 21a9.753 9.753 0 009.002-5.998z"/>
                            </svg>
                            Mode Gelap
                        </span>
                        {{-- Toggle switch --}}
                        <button type="button"
                                @click="toggleDarkMode()"
                                class="relative w-9 h-5 rounded-full transition-colors focus:outline-none"
                                :class="dark ? 'bg-primary' : 'bg-gray-200 dark:bg-slate-700'">
                            <span class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"
                                  :class="dark ? 'translate-x-4' : 'translate-x-0'">
                            </span>
                        </button>
                    </div>

                    <div class="border-t border-gray-100 dark:border-slate-800/80 my-1"></div>

                    {{-- Menu items --}}
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        Syarat & Ketentuan
                    </a>

                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Kebijakan Privasi
                    </a>

                    <a href="mailto:admin@biconnect.bsi.ac.id" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        Hubungi Admin
                    </a>

                    <div class="border-t border-gray-100 dark:border-slate-800/80 my-1"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 dark:text-red-400
                                       hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                            Keluar
                        </button>
                    </form>

                </div>
            </div>

            {{-- Avatar --}}
            <a href="{{ route('profile.show') }}" id="nav-profile-btn"
               class="w-8 h-8 rounded-full bg-primary-light overflow-hidden ring-2 ring-transparent hover:ring-primary/30 transition-all ml-1 shrink-0">
                <img src="{{ auth()->user()?->avatar_url }}"
                     alt="Profil" class="w-full h-full object-cover" loading="lazy">
            </a>
        </div>
    </div>
</nav>

@push('scripts')
<script>
function navSettingsDropdown() {
    return {
        open: false,
        dark: document.documentElement.classList.contains('dark'),
        toggleDarkMode() {
            this.dark = !this.dark;
            document.documentElement.classList.toggle('dark', this.dark);

            // Save to server via AJAX
            fetch('{{ route('settings.dark-mode') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ dark_mode: this.dark })
            }).catch(err => console.error('Dark mode save failed:', err));
        }
    };
}
</script>
@endpush
