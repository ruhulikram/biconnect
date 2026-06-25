@props([
    'label'       => null,
    'error'       => null,
    'helper'      => null,
    'icon'        => null,
    'iconRight'   => null,
    'name'        => null,
])

<div class="space-y-1.5">
    @if($label)
        <label class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ $label }}</label>
    @endif

    <div class="relative">
        @if($icon)
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                {!! $icon !!}
            </span>
        @endif

        <input
            @if($name) id="{{ $name }}" name="{{ $name }}" @endif
            {{ $attributes->merge([
                'class' => 'w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm
                            placeholder-gray-400 dark:placeholder-slate-500 text-gray-900 dark:text-slate-100 transition-all duration-150
                            focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20
                            ' . ($icon ? 'pl-10.5 ' : '')
                            . ($error ? 'border-red-500 dark:border-red-500 focus:ring-red-500/20 ' : '')
                            . ($iconRight ? 'pr-10.5 ' : '')
            ]) }}>

        @if($iconRight)
            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                {!! $iconRight !!}
            </span>
        @endif
    </div>

    @if($error)
        <p class="text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            {{ $error }}
        </p>
    @elseif($helper)
        <p class="text-xs text-gray-400 dark:text-slate-500">{{ $helper }}</p>
    @endif
</div>
