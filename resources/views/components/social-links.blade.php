@props([
    'links' => [],
])

@php
$icons = [
    'linkedin'  => '<path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/>',
    'github'    => '<path d="M15 22v-4a4.8 4.8 0 00-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 004 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4M15 18c-6 2-7-4-7-4"/>',
    'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/>',
    'twitter'   => '<path d="M4 4l11.733 16h4.267l-11.733-16zM4 20l6.768-6.768M20 4l-6.768 6.768"/>',
    'website'   => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 000 20 14.5 14.5 0 000-20M2 12h20"/>',
];

$colors = [
    'linkedin'  => 'hover:text-blue-600',
    'github'    => 'hover:text-gray-900 dark:hover:text-white',
    'instagram' => 'hover:text-pink-500',
    'twitter'   => 'hover:text-gray-900 dark:hover:text-white',
    'website'   => 'hover:text-primary',
];
@endphp

@if($links->count())
    <div class="flex flex-wrap items-center gap-2.5">
        @foreach($links as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" title="{{ \App\Models\SocialLink::platforms()[$link->platform] ?? $link->platform }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 {{ $colors[$link->platform] ?? 'hover:text-primary' }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    {!! $icons[$link->platform] ?? $icons['website'] !!}
                </svg>
            </a>
        @endforeach
    </div>
@endif
