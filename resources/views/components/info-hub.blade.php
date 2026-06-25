@props([
    'posters' => [],
])

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-card p-5 sticky top-20">
    <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
        </svg>
        Informasi Kampus
    </h3>

    <div class="space-y-4">
        @forelse($posters as $poster)
            <a href="{{ $poster->poster_link ?: '#' }}"
               @if($poster->poster_link) target="_blank" rel="noopener noreferrer" @endif
               class="block rounded-lg overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow group">
                <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    <img src="{{ asset('storage/' . $poster->poster_image) }}"
                         alt="Informasi Kampus"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
            </a>
        @empty
            <div class="text-center py-8">
                <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-500">Belum ada informasi</p>
            </div>
        @endforelse
    </div>
</div>
