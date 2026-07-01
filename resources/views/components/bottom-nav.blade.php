@php
    $currentRoute = request()->route()?->getName();
    $unreadCount = auth()->user()?->unreadNotifications->count() ?? 0;
@endphp

<nav class="fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-t border-gray-200 dark:border-gray-800 h-16 flex items-center safe-area-bottom transition-colors">
    <div class="w-full grid grid-cols-4 h-full">

        <!--{{-- Feed / Home --}}
        <a href="{{ route('feed.index') }}" id="bnav-feed"
           class="flex flex-col items-center justify-center gap-0.5 transition-colors
                  {{ $currentRoute === 'feed.index' && !request('type') ? 'text-primary' : 'text-gray-400 dark:text-gray-500' }}">
            <svg class="w-6 h-6" fill="{{ $currentRoute === 'feed.index' && !request('type') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <span class="text-[10px] font-semibold">Feed</span>
        </a>

        {{-- Project --}}
        <a href="{{ route('feed.index') }}?type=project" id="bnav-project"
           class="flex flex-col items-center justify-center gap-0.5 transition-colors
                  {{ request('type') === 'project' ? 'text-primary' : 'text-gray-400 dark:text-gray-500' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
            </svg>
            <span class="text-[10px] font-semibold">Project</span>
        </a>-->

        {{-- Notifikasi --}}
        <a href="{{ route('notifications.index') }}" id="bnav-notifications"
           class="flex flex-col items-center justify-center gap-0.5 transition-colors relative
                  {{ $currentRoute === 'notifications.index' ? 'text-primary' : 'text-gray-400 dark:text-gray-500' }}">
            <div class="relative">
                <x-ui.icon name="bell" class="w-6 h-6" :fill="$currentRoute === 'notifications.index' ? 'currentColor' : 'none'" stroke-width="1.5" />
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 ring-2 ring-white dark:ring-gray-900">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </div>
            <span class="text-[10px] font-semibold">Notifikasi</span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profile.show') }}" id="bnav-profile"
           class="flex flex-col items-center justify-center gap-0.5 transition-colors
                  {{ $currentRoute === 'profile.show' ? 'text-primary' : 'text-gray-400 dark:text-gray-500' }}">
            <svg class="w-6 h-6" fill="{{ $currentRoute === 'profile.show' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>

    </div>
</nav>
