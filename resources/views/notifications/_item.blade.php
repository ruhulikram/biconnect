@php
    $isUnread = is_null($notification->read_at);
    $data = $notification->data;

    // Determine icon based on notification type
    $typeKey = class_basename($notification->type);
    $icons = [
        'NewFollower' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>',
            'bg' => 'bg-blue-100 dark:bg-blue-950/40',
            'text' => 'text-blue-600 dark:text-blue-400',
        ],
        'PostInterest' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
            'bg' => 'bg-red-100 dark:bg-red-950/40',
            'text' => 'text-red-500 dark:text-red-400',
        ],
        'NewComment' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.583-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.124-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>',
            'bg' => 'bg-emerald-100 dark:bg-emerald-950/40',
            'text' => 'text-emerald-600 dark:text-emerald-400',
        ],
    ];

    $iconData = $icons[$typeKey] ?? [
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>',
        'bg' => 'bg-gray-100 dark:bg-gray-800',
        'text' => 'text-gray-500 dark:text-gray-400',
    ];

    $url = $data['url'] ?? '#';
    $avatarUrl = $data['avatar_url'] ?? null;
    $actorName = $data['actor_name'] ?? null;
@endphp

<a href="{{ $url }}"
   class="flex items-start gap-3 px-4 py-3.5 rounded-card transition-colors group
          {{ $isUnread
             ? 'bg-primary-light/60 dark:bg-primary/5 border-l-[3px] border-l-primary'
             : 'bg-white dark:bg-slate-900 border-l-[3px] border-l-transparent hover:bg-gray-50 dark:hover:bg-slate-800/60' }}">

    {{-- Icon / Avatar --}}
    <div class="shrink-0 mt-0.5">
        @if($avatarUrl)
            <img src="{{ $avatarUrl }}" alt=""
                 class="w-10 h-10 rounded-full object-cover bg-primary-light">
        @else
            <div class="w-10 h-10 rounded-full {{ $iconData['bg'] }} flex items-center justify-center">
                <svg class="w-5 h-5 {{ $iconData['text'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    {!! $iconData['icon'] !!}
                </svg>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="flex-1 min-w-0">
        <p class="text-sm text-gray-700 dark:text-gray-300 leading-snug">
            @if($actorName)
                <span class="font-semibold text-gray-900 dark:text-white">{{ $actorName }}</span>
            @endif
            {{ $data['message'] ?? 'Kamu punya notifikasi baru.' }}
        </p>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
            {{ $notification->created_at->diffForHumans() }}
        </p>
    </div>

    {{-- Unread dot --}}
    @if($isUnread)
        <span class="w-2.5 h-2.5 bg-primary rounded-full shrink-0 mt-2"></span>
    @endif
</a>
