@props(['post'])

<article onclick="if(!event.target.closest('a,button')){window.location.href='{{ route('post.show', $post) }}'}"
         class="bg-white border border-gray-200 dark:border-slate-800 rounded-card p-5 shadow-sm hover:shadow-md hover:border-gray-300 dark:hover:border-slate-700 transition-all duration-200 dark:bg-slate-900 flex flex-col justify-between h-full cursor-pointer">
    <div>
        {{-- Header --}}
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-2.5 min-w-0">
                {{-- Reusable Avatar Component --}}
                <x-ui.avatar :src="$post->user->avatar_url" :verified="$post->user->is_verified" size="md" />
                
                <div class="min-w-0">
                    <a href="{{ route('profile.show.user', $post->user) }}" class="text-sm font-semibold text-gray-900 dark:text-white truncate hover:text-primary transition-colors">
                        {{ $post->user->name }}
                    </a>
                    <p class="text-xs text-gray-400 dark:text-gray-500 truncate">
                        {{ $post->user->program ?? 'Mahasiswa BSI' }} · {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 shrink-0">
                {{-- Status badge (visible to owner only) --}}
                @if(auth()->check() && $post->user_id === auth()->id())
                    @if($post->status === 'pending')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                        </span>
                    @elseif($post->status === 'rejected')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                            Ditolak
                        </span>
                    @elseif($post->status === 'closed')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            Closed
                        </span>
                    @endif
                @endif
                @if($post->project_type)
                    <x-ui.badge :type="$post->project_type">{{ $post->project_type }}</x-ui.badge>
                @endif
                <x-ui.badge type="project">PROJECT</x-ui.badge>
            </div>
        </div>

        {{-- Title & Description --}}
        <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white mb-1 line-clamp-2 hover:text-primary transition-colors cursor-pointer">
            <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3 leading-relaxed">
            {{ $post->body }}
        </p>

        {{-- Skills --}}
        @if($post->skills && $post->skills->count())
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach($post->skills->take(4) as $skill)
                    <x-ui.chip>{{ $skill->name }}</x-ui.chip>
                @endforeach
                @if($post->skills->count() > 4)
                    <x-ui.chip :selected="true">
                        +{{ $post->skills->count() - 4 }}
                    </x-ui.chip>
                @endif
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800/40">
        <div class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
            <!-- ICON_MARK: DEADLINE -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            <span>Deadline {{ $post->deadline?->format('d M Y') ?? 'Fleksibel' }}</span>
        </div>
        <div>
            <x-ui.button variant="outlined" size="sm" :href="route('post.show', $post)">
                Lihat Detail
            </x-ui.button>
        </div>
    </div>
</article>
