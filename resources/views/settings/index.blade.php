@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-6 py-4">

    {{-- ═══════ Top Bar ═══════ --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('feed.index') }}"
           class="p-1.5 rounded-input hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <h1 class="text-lg font-bold font-heading text-gray-900 dark:text-white">Pengaturan</h1>
    </div>

    {{-- ═══════ Section: Tampilan ═══════ --}}
    <div class="mb-6">
        <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3 px-1">Tampilan</h2>
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-card overflow-hidden">

            {{-- Dark Mode Toggle --}}
            <div x-data="darkModeToggle()" class="flex items-center justify-between px-4 py-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Mode Gelap</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Tampilan yang lebih nyaman di malam hari</p>
                    </div>
                </div>

                {{-- Toggle Switch --}}
                <button type="button"
                        @click="toggle()"
                        :class="enabled ? 'bg-primary' : 'bg-gray-300 dark:bg-slate-600'"
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <span :class="enabled ? 'translate-x-5' : 'translate-x-0.5'"
                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out mt-0.5"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════ Section: Tentang ═══════ --}}
    <div class="mb-6">
        <h2 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3 px-1">Tentang</h2>
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-card overflow-hidden divide-y divide-gray-100 dark:divide-slate-800">

            {{-- Versi --}}
            <div class="flex items-center justify-between px-4 py-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Versi Aplikasi</p>
                    </div>
                </div>
                <span class="text-sm text-gray-400 dark:text-gray-500">1.0.0</span>
            </div>

            {{-- Syarat & Ketentuan --}}
            <a href="#" class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Syarat & Ketentuan</p>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>

            {{-- Kebijakan Privasi --}}
            <a href="#" class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Kebijakan Privasi</p>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>

            {{-- Hubungi Admin --}}
            <a href="mailto:admin@biconnect.bsi.ac.id" class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-slate-800/60 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Hubungi Admin</p>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- ═══════ Logout Button ═══════ --}}
    <div class="pb-6">
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-white dark:bg-slate-900 border border-red-200 dark:border-red-900/40 text-red-600 dark:text-red-400 font-semibold text-sm rounded-card hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
                Keluar dari Akun
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
function darkModeToggle() {
    return {
        enabled: document.documentElement.classList.contains('dark'),

        toggle() {
            this.enabled = !this.enabled;
            document.documentElement.classList.toggle('dark', this.enabled);

            // Save to server via AJAX
            fetch('{{ route('settings.dark-mode') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ dark_mode: this.enabled })
            }).catch(err => console.error('Dark mode save failed:', err));
        }
    };
}
</script>
@endpush
