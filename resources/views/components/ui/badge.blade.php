@props([
    'type' => 'project',
])

@php
$styles = [
    'project'   => 'bg-accent-light text-accent dark:bg-amber-950/25 dark:text-amber-400',
    'paid'      => 'bg-green-50 text-green-700 dark:bg-emerald-950/25 dark:text-emerald-400',
    'unpaid'    => 'bg-gray-100 text-gray-600 dark:bg-slate-800 dark:text-slate-400',
    'portfolio' => 'bg-primary-light text-primary dark:bg-blue-950/25 dark:text-blue-400',
    'discussion'=> 'bg-blue-50 text-blue-700 dark:bg-blue-950/25 dark:text-blue-400',
    'pending'   => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-950/25 dark:text-yellow-400',
    'handled'   => 'bg-green-50 text-green-700 dark:bg-emerald-950/25 dark:text-emerald-400',
    'rejected'  => 'bg-red-50 text-red-600 dark:bg-red-950/25 dark:text-red-400',
];
@endphp

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center px-2.5 py-1 rounded-pill text-[11px] font-semibold uppercase tracking-wide leading-none '
               . ($styles[$type] ?? $styles['project'])
]) }}>
    {{ $slot }}
</span>
