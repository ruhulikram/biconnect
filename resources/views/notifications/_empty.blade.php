@php
    $emptyMessage = $message ?? 'Belum ada notifikasi';
@endphp

<div class="text-center py-16">
    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
        </svg>
    </div>
    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ $emptyMessage }}</h3>
    <p class="text-xs text-gray-400">Notifikasi baru akan muncul di sini.</p>
</div>
