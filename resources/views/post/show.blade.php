@extends('layouts.app')
@section('title', ($post->title ?? 'Post') . ' — BiConnect')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-4">

    {{-- Top Bar --}}
    <div class="flex items-center justify-between mb-5">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('feed.index') }}"
           class="p-2 -ml-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>

        <div class="flex items-center gap-1">
            {{-- Share --}}
            <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    onclick="sharePost('{{ addslashes($post->title ?? 'Post BiConnect') }}', window.location.href)">
                <x-ui.icon name="share" class="w-5 h-5" stroke-width="1.5" />
            </button>

            {{-- Like --}}
            @php
                $detailIsLiked = auth()->check() && auth()->user()->likedPosts->contains($post->id);
            @endphp
            <button @click="
                    liked = !liked;
                    liked ? count++ : count--;
                    fetch('{{ route('post.like', $post) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                    }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; });
                "
                x-data="{ liked: {{ $detailIsLiked ? 'true' : 'false' }}, count: {{ $post->likes_count ?? 0 }} }"
                :class="liked ? 'text-red-500' : 'text-gray-500 hover:text-red-500'"
                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <x-ui.icon name="like" class="w-5 h-5" x-bind:fill="liked ? 'currentColor' : 'none'" stroke-width="2" />
            </button>

            {{-- Three-dot Menu --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.outside="open = false"
                        class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                    </svg>
                </button>
                <div x-show="open" x-transition
                     class="absolute right-0 mt-1 w-44 bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-lg shadow-lg py-1 z-10"
                     style="display: none;">
                    @if($post->user_id === auth()->id())
                        {{-- Close Project (owner only, approved projects only) --}}
                        @if($post->type === 'project' && $post->status === 'approved')
                            <form action="{{ route('post.close', $post) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menutup project ini? Project tidak akan tampil di feed.')">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tutup Project
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('post.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus post ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm hover:bg-red-50 dark:hover:bg-red-950/30 text-red-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Hapus Post
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Status Banner (for project posts) --}}
    @if($post->type === 'project' && $post->status !== 'approved')
        <div class="mb-4 px-4 py-3 rounded-xl border text-sm font-semibold flex items-center gap-3
                    {{ $post->status === 'pending' ? 'bg-amber-50 border-amber-200 text-amber-700 dark:bg-amber-950/20 dark:border-amber-800 dark:text-amber-400' : '' }}
                    {{ $post->status === 'rejected' ? 'bg-red-50 border-red-200 text-red-700 dark:bg-red-950/20 dark:border-red-800 dark:text-red-400' : '' }}
                    {{ $post->status === 'closed' ? 'bg-gray-100 border-gray-200 text-gray-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400' : '' }}">
            @if($post->status === 'pending')
                <svg class="w-5 h-5 shrink-0 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <span>Project ini sedang <strong>menunggu persetujuan</strong> admin. Belum tampil di feed publik.</span>
            @elseif($post->status === 'rejected')
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>Project ini <strong>ditolak</strong> oleh admin dan tidak tampil di feed.</span>
            @elseif($post->status === 'closed')
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Project ini sudah <strong>ditutup</strong> dan tidak lagi menerima ketertarikan.</span>
            @endif
        </div>
    @endif

    {{-- Post Content Card --}}
    <article class="bg-white dark:bg-gray-900 border border-border dark:border-gray-800 rounded-card shadow-card overflow-hidden">

        {{-- Optional Image --}}
        @if($post->image)
            <div class="w-full max-h-[300px] overflow-hidden bg-gray-100 dark:bg-gray-950">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                     class="w-full h-full object-cover" loading="lazy">
            </div>
        @endif

        <div class="p-5">
            {{-- Badge --}}
            @if($post->type === 'project')
                <div class="flex items-center gap-2 mb-3">
                    <x-ui.badge type="project">PROJECT</x-ui.badge>
                    @if($post->project_type)
                        <x-ui.badge :type="$post->project_type">{{ $post->project_type }}</x-ui.badge>
                    @endif
                </div>
            @endif

            {{-- Title --}}
            @if($post->title)
                <h2 class="text-xl md:text-2xl font-black font-heading text-gray-900 dark:text-white leading-snug mb-4">
                    {{ $post->title }}
                </h2>
            @endif

            {{-- Poster Row --}}
            <div class="flex items-center gap-3 mb-5">
                <x-ui.avatar :src="$post->user->avatar_url" :verified="$post->user->is_verified" size="md" />
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        {{ $post->user->program ?? 'Mahasiswa BSI' }} · {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            {{-- Body --}}
            <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed mb-5 whitespace-pre-line">
                {{ $post->body }}
            </div>

            {{-- Skill Chips --}}
            @if($post->skills->count())
                <div class="flex flex-wrap gap-1.5 mb-5">
                    @foreach($post->skills as $skill)
                        <x-ui.chip>{{ $skill->name }}</x-ui.chip>
                    @endforeach
                </div>
            @endif

            {{-- Info Grid (Project only) --}}
            @if($post->type === 'project')
                <div class="grid grid-cols-3 gap-3 mb-5">
                    {{-- Deadline --}}
                    <div class="bg-gray-50 dark:bg-gray-950 rounded-lg p-3 text-center border border-border/50 dark:border-gray-800">
                        <div class="flex items-center justify-center text-gray-400 mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Deadline</p>
                        <p class="text-xs font-bold text-gray-900 dark:text-white mt-0.5">
                            {{ $post->deadline?->format('d M Y') ?? 'Fleksibel' }}
                        </p>
                    </div>
                    {{-- Area --}}
                    <div class="bg-gray-50 dark:bg-gray-950 rounded-lg p-3 text-center border border-border/50 dark:border-gray-800">
                        <div class="flex items-center justify-center text-gray-400 mb-1">
                            <x-ui.icon name="location" class="w-4 h-4" stroke-width="1.5" />
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Area</p>
                        <p class="text-xs font-bold text-gray-900 dark:text-white mt-0.5">
                            {{ $post->campus_area ?? 'Semua' }}
                        </p>
                    </div>
                    {{-- Tipe --}}
                    <div class="bg-gray-50 dark:bg-gray-950 rounded-lg p-3 text-center border border-border/50 dark:border-gray-800">
                        <div class="flex items-center justify-center text-gray-400 mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                            </svg>
                        </div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Tipe</p>
                        <p class="text-xs font-bold text-gray-900 dark:text-white mt-0.5 capitalize">
                            {{ $post->project_type ?? '-' }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- "Yang Sudah Tertarik" Section (Project only) --}}
            @if($post->type === 'project')
                <div class="bg-gray-50 dark:bg-gray-950 rounded-lg p-4 mb-5 border border-border/50 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Yang Sudah Tertarik</h4>
                            <div class="flex items-center gap-2">
                                {{-- Overlapping avatars --}}
                                <div class="flex -space-x-2">
                                    @foreach($post->interests->take(5) as $interest)
                                        <img src="{{ $interest->user->avatar_url }}" alt="{{ $interest->user->name }}"
                                             class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-950 object-cover"
                                             title="{{ $interest->user->name }}">
                                    @endforeach
                                    @if($post->interests_count > 5)
                                        <span class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-950 bg-primary-light dark:bg-primary/10 text-primary text-[10px] font-bold flex items-center justify-center">
                                            +{{ $post->interests_count - 5 }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1 font-medium">
                                    {{ $post->interests_count }} orang tertarik
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </article>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- Comment Section                                         --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section id="comments" class="mt-6">
        <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.583-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.124-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
            </svg>
            Komentar ({{ $post->comments_count }})
        </h3>

        {{-- Comment Input --}}
        <form action="{{ route('post.comment', $post) }}" method="POST" class="mb-6">
            @csrf
            <div class="flex items-start gap-3">
                <x-ui.avatar :src="auth()->user()->avatar_url" size="sm" class="mt-1" />
                <div class="flex-1 relative">
                    <textarea name="body" rows="2"
                              placeholder="Tulis komentar..."
                              class="w-full rounded-input border border-border dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:shadow-focus resize-none pr-12 transition-shadow">{{ old('body') }}</textarea>
                    <button type="submit"
                            class="absolute right-2 bottom-2 p-2 text-primary hover:bg-primary-light dark:hover:bg-primary/10 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                    </button>
                </div>
            </div>
            @error('body')
                <p class="text-xs text-red-500 mt-1 ml-11">{{ $message }}</p>
            @enderror
        </form>

        {{-- Comment List --}}
        <div class="space-y-4">
            @forelse($post->comments as $comment)
                <div class="flex items-start gap-3" id="comment-{{ $comment->id }}">
                    <x-ui.avatar :src="$comment->user->avatar_url" :verified="$comment->user->is_verified" size="sm" class="mt-0.5" />
                    <div class="flex-1 min-w-0">
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg px-4 py-3 border border-border/50 dark:border-gray-800/50">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $comment->body }}</p>
                        </div>

                        {{-- Reply toggle --}}
                        <div x-data="{ showReply: false }" class="mt-1.5 ml-1">
                            <button @click="showReply = !showReply" class="text-xs font-semibold text-gray-400 hover:text-primary transition-colors">
                                Balas
                            </button>

                            {{-- Reply Input --}}
                            <div x-show="showReply" x-transition class="mt-2" style="display: none;">
                                <form action="{{ route('post.comment', $post) }}" method="POST" class="flex items-start gap-2">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <x-ui.avatar :src="auth()->user()->avatar_url" size="sm" />
                                    <div class="flex-1 relative">
                                        <textarea name="body" rows="1" placeholder="Balas komentar..."
                                                  class="w-full rounded-input border border-border dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-xs text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:shadow-focus resize-none pr-10"></textarea>
                                        <button type="submit"
                                                class="absolute right-1.5 bottom-1.5 p-1.5 text-primary hover:bg-primary-light dark:hover:bg-primary/10 rounded-full transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Nested Replies --}}
                            @if($comment->replies->count())
                                <div class="mt-3 space-y-3 pl-2 border-l-2 border-border dark:border-gray-800">
                                    @foreach($comment->replies as $reply)
                                        <div class="flex items-start gap-2.5" id="comment-{{ $reply->id }}">
                                            <x-ui.avatar :src="$reply->user->avatar_url" size="sm" />
                                            <div class="flex-1 min-w-0">
                                                <div class="bg-white dark:bg-gray-800 rounded-lg px-3 py-2 border border-border/40 dark:border-gray-800/40">
                                                    <div class="flex items-center gap-2 mb-0.5">
                                                        <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                                                        <span class="text-[10px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">{{ $reply->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="text-3xl mb-2">💬</div>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Spacer for sticky bottom bar --}}
    @if($post->type === 'project')
        <div class="h-24"></div>
    @endif
</div>

{{-- Sticky Bottom CTA (Project only, approved only) --}}
@if($post->type === 'project' && $post->status === 'approved' && $post->user_id !== auth()->id())
    <div class="fixed bottom-16 md:bottom-0 inset-x-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-t border-border dark:border-gray-800 z-30 safe-area-bottom">
        <div class="max-w-2xl mx-auto px-4 py-3">
            @if($post->status === 'closed')
                <div class="flex items-center justify-center gap-2 h-12 w-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-input text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Project Ditutup
                </div>
            @elseif($alreadyInterested)
                <div class="flex items-center justify-center gap-2 h-12 w-full bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 rounded-input text-sm font-semibold border border-green-200 dark:border-green-900/40">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    Ketertarikan Sudah Dikirim
                </div>
            @else
                <form action="{{ route('interest.store', $post) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full h-12 bg-accent text-white text-sm font-bold rounded-input hover:brightness-110 transition-all shadow-fab flex items-center justify-center gap-2 active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                        </svg>
                        Saya Tertarik
                    </button>
                </form>
            @endif
        </div>
    </div>
@endif
@endsection
