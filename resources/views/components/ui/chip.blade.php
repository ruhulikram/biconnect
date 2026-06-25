@props([
    'selected'   => false,
    'removable'  => false,
    'value'      => '',
])

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center gap-1.5 px-3 py-1 rounded-pill text-xs font-semibold cursor-pointer transition-all duration-150 select-none border '
               . ($selected
                  ? 'bg-primary-light text-primary border-primary/20 dark:bg-primary/10 dark:border-primary/30 dark:text-primary-light'
                  : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-100 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-750 dark:hover:border-slate-600')
]) }}>
    {{ $slot }}

    @if($removable)
        <button type="button"
                class="text-current opacity-60 hover:opacity-100 transition-opacity ml-0.5 -mr-0.5"
                aria-label="Remove">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</span>
