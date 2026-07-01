@props(['post'])

<article onclick="if(!event.target.closest('a,button')){window.location.href='{{ route('post.show', $post) }}'}"
         class="bg-white border border-gray-200 dark:border-slate-800 rounded-card p-5 shadow-sm hover:shadow-md hover:border-gray-300 dark:hover:border-slate-700 transition-all duration-200 dark:bg-slate-900 cursor-pointer">
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
            @php
                $isLiked = auth()->check() && auth()->user()->likedPosts->contains($post->id);
            @endphp
            <button @click="
                    liked = !liked;
                    liked ? count++ : count--;
                    fetch('{{ route('post.like', $post) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                    }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; });
                "
                x-data="{ liked: {{ $isLiked ? 'true' : 'false' }}, count: {{ $post->likes_count ?? 0 }} }"
                :class="liked ? 'text-red-500' : 'text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400'"
                class="flex items-center gap-1.5 text-xs font-medium group transition-colors">
                <!-- ICON_MARK: LIKE -->
                <x-ui.icon name="like" class="w-4.5 h-4.5 group-hover:scale-110 transition-transform"
                     x-bind:fill="liked ? 'currentColor' : 'none'"
                     stroke-width="1.5" />
                <span x-text="count"></span>
            </button>

            {{-- Comments --}}
            <a href="{{ route('post.show', $post) }}#comments" 
               class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                <!-- ICON_MARK: COMMENT -->
                <x-ui.icon name="comment" class="w-4.5 h-4.5" stroke-width="1.5" />
                <span>{{ $post->comments_count ?? 0 }}</span>
            </a>

            {{-- Share --}}
            <button class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                    onclick="sharePost('{{ addslashes($post->title ?? 'Post BiConnect') }}', '{{ route('post.show', $post) }}')">
                <!-- ICON_MARK: SHARE -->
                <x-ui.icon name="share" class="w-4.5 h-4.5" stroke-width="1.5" />
                <span class="hidden sm:inline">Bagikan</span>
            </button>
        </div>

        {{-- Bookmark --}}
        <button class="text-gray-400 hover:text-primary dark:text-gray-500 dark:hover:text-primary transition-colors">
            <!-- ICON_MARK: BOOKMARK -->
            <x-ui.icon name="bookmark" class="w-4.5 h-4.5" stroke-width="1.5" />
        </button>
    </div>
</article>
