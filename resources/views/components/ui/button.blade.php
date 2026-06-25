@props([
    'variant'  => 'primary',   // primary | outlined | text | danger
    'size'     => 'md',        // sm | md | lg
    'type'     => 'button',
    'disabled' => false,
    'full'     => false,
    'href'     => null,
])

@php
$base = 'inline-flex items-center justify-center font-semibold rounded-input transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-primary/20 active:scale-[0.98] cursor-pointer select-none';

$sizes = [
    'sm' => 'px-3.5 py-1.5 text-xs gap-1.5 h-9',
    'md' => 'px-5 py-3 text-sm gap-2 h-12',
    'lg' => 'px-6 py-3.5 text-base gap-2.5 h-14',
];

$variants = [
    'primary'  => 'bg-primary text-white hover:bg-primary-dark active:bg-primary-dark disabled:opacity-40 disabled:cursor-not-allowed shadow-sm',
    'outlined' => 'border border-primary text-primary hover:bg-primary-light active:bg-primary-light/70 disabled:opacity-40 disabled:cursor-not-allowed',
    'text'     => 'text-primary hover:bg-primary-light active:bg-primary-light/60 disabled:opacity-40 disabled:cursor-not-allowed',
    'danger'   => 'text-danger border border-red-200 hover:bg-red-50 active:bg-red-100 disabled:opacity-40 disabled:cursor-not-allowed',
];

$classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']) . ($full ? ' w-full' : '');
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
