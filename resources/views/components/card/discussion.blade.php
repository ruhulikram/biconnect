@props(['post'])

<article class="bg-white border border-gray-200 dark:border-slate-800 rounded-card p-5 shadow-sm hover:shadow-md hover:border-gray-300 dark:hover:border-slate-700 transition-all duration-200 dark:bg-slate-900">
    {{-- Card Header --}}
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-3 min-w-0">
            {{-- Avatar Component --}}
            <x-ui.avatar :src="$post->user->avatar_url" :verified="$post->user->is_verified" size="md" />
            
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate hover:text-primary transition-colors cursor-pointer">
                        <a href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a>
                    </h4>
                    @if($post->user->is_admin)
                        <span class="bg-red-50 text-red-650 dark:bg-red-950/30 dark:text-red-400 text-[10px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider scale-90">
                            Staff
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-500 truncate">
                    {{ $post->user->program ?? 'Mahasiswa BSI' }} &middot; {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        {{-- Dropdown Menu (Alpine.js) --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false" 
                    class="p-1.5 rounded-full text-gray-400 hover:text-gray-650 hover:bg-gray-50 dark:hover:bg-slate-800 dark:hover:text-slate-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                </svg>
            </button>
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-md py-1 z-10 text-sm"
                 style="display: none;">
                    <a href="{{ route('report.create', ['type' => 'post', 'id' => $post->id]) }}"
                       class="w-full text-left px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-350 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"/>
                        </svg>
                        Laporkan Post
                    </a>
            </div>
        </div>
    </div>

    {{-- Post Title --}}
    @if($post->title)
        <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white mt-3 leading-snug hover:text-primary transition-colors cursor-pointer">
            <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
        </h3>
    @endif

    {{-- Post Body --}}
    <div class="mt-2">
        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3 leading-relaxed whitespace-pre-line">
            {{ $post->body }}
        </p>
        <a href="{{ route('post.show', $post) }}" class="text-xs font-semibold text-primary hover:underline mt-1 inline-block">
            Selengkapnya
        </a>
    </div>

    {{-- Optional Image --}}
    @if($post->image)
        <div class="mt-3 rounded-lg overflow-hidden border border-border dark:border-gray-800 bg-gray-50 dark:bg-gray-950 max-h-[300px] flex items-center justify-center">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Attachment" 
                 class="w-full h-full object-cover select-none" loading="lazy"
                 onerror="this.parentNode.style.display='none'">
        </div>
    @endif

    {{-- Action Row --}}
    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-150 dark:border-slate-800/60">
        <div class="flex items-center gap-4">
            {{-- Likes --}}
            <button class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 group transition-colors">
                <svg class="w-4.5 h-4.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                <span>{{ $post->likes_count ?? 0 }}</span>
            </button>

            {{-- Comments --}}
            <a href="{{ route('post.show', $post) }}#comments" 
               class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.583-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.124-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                </svg>
                <span>{{ $post->comments_count ?? 0 }}</span>
            </a>

            {{-- Share --}}
            <button class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                    onclick="if(navigator.share) { navigator.share({ title: '{{ $post->title ?? 'Post BiConnect' }}', url: '{{ route('post.show', $post) }}' }) } else { navigator.clipboard.writeText('{{ route('post.show', $post) }}'); alert('Tautan berhasil disalin!') }">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186l5.577-3.253m-5.577 6.137l5.577 3.253m0 0a2.25 2.25 0 103.58 2.2V16.5a2.25 2.25 0 00-3.58-2.2m0 0a2.25 2.25 0 100-2.2M16.33 7.5a2.25 2.25 0 100-2.2V6.75a2.25 2.25 0 000 2.2"/>
                </svg>
                <span class="hidden sm:inline">Bagikan</span>
            </button>
        </div>

        {{-- Bookmark --}}
        <button class="text-gray-400 hover:text-primary dark:text-gray-500 dark:hover:text-primary transition-colors">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
            </svg>
        </button>
    </div>
</article>
