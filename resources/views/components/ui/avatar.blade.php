@props([
    'src'      => null,
    'alt'      => '',
    'size'     => 'md',
    'verified' => false,
])

@php
$sizes = [
    'sm' => 'w-8 h-8',
    'md' => 'w-10 h-10',
    'lg' => 'w-14 h-14',
    'xl' => 'w-20 h-20',
];

$badgeSizes = [
    'sm' => 'w-3 h-3 -bottom-0 -right-0',
    'md' => 'w-3.5 h-3.5 -bottom-0 -right-0',
    'lg' => 'w-4 h-4 bottom-0 right-0',
    'xl' => 'w-5 h-5 bottom-0.5 right-0.5',
];

$sizeClass = $sizes[$size] ?? $sizes['md'];
$badgeClass = $badgeSizes[$size] ?? $badgeSizes['md'];
$fallback = 'https://ui-avatars.com/api/?name=' . urlencode($alt ?: 'User') . '&background=EEF2FF&color=2C5BFF&size=128&bold=true';
@endphp

<div class="relative inline-flex shrink-0" {{ $attributes }}>
    <img
        src="{{ $src ?: $fallback }}"
        alt="{{ $alt }}"
        class="{{ $sizeClass }} rounded-full object-cover bg-primary-light"
        loading="lazy"
        onerror="this.src='{{ $fallback }}'">

    @if($verified)
        <span class="absolute {{ $badgeClass }} bg-primary rounded-full ring-2 ring-white dark:ring-gray-900 flex items-center justify-center">
            <svg class="w-2/3 h-2/3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
            </svg>
        </span>
    @endif
</div>
