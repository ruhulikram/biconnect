@extends('layouts.app')
@section('title', $isOwner ? 'Profil Saya' : $user->name)
@section('meta_description', ($user->bio ?? 'Profil mahasiswa BiConnect') . ' — ' . ($user->program ?? 'BSI'))

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- ═══════ Cover Image ═══════ --}}
        <div class="relative h-[120px] md:h-[160px] bg-gray-100 dark:bg-slate-800 overflow-hidden z-0">
            <img src="{{ $user->cover_url }}" alt="Cover" class="w-full h-full object-cover"
                onerror="this.src='https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-0"></div>

            {{-- Three-dot menu for other user --}}
            @if(!$isOwner)
                <div x-data="{ open: false }" class="absolute top-3 right-3">
                    <button @click="open = !open" @click.outside="open = false"
                        class="p-1.5 rounded-full bg-black/30 backdrop-blur-sm text-white hover:bg-black/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-1 w-44 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-md shadow-md py-1 z-10 text-sm"
                        style="display: none;">
                        <a href="{{ route('report.create', ['type' => 'user', 'id' => $user->id]) }}"
                            class="w-full text-left px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                            Laporkan
                        </a>
                        <button
                            class="w-full text-left px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-slate-700 text-red-500 dark:text-red-400 flex items-center gap-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Blokir
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- ═══════ Profile Info Section ═══════ --}}
        <div class="px-4 md:px-6">

            {{-- Avatar (positioned overlapping the cover with proper z-index) --}}
            <div class="relative z-10 -mt-[40px] mb-3 ml-1">
                <div
                    class="w-[80px] h-[80px] rounded-full border-[3px] border-white dark:border-slate-900 overflow-hidden bg-primary-light shadow-md">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=EEF2FF&color=2C5BFF&size=128&bold=true'">
                </div>
            </div>

            {{-- Name & Verified --}}
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white">{{ $user->name }}</h1>
                @if($user->is_verified)
                    <span class="bg-primary rounded-full w-5 h-5 flex items-center justify-center shrink-0"
                        title="Terverifikasi">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>

            {{-- Subtitle info --}}
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-gray-500 dark:text-gray-400 mb-4">
                @if($user->program)
                    <span>{{ $user->program }}</span>
                @endif
                @if($user->semester)
                    <span class="text-gray-300 dark:text-gray-600">&middot;</span>
                    <span>Semester {{ $user->semester }}</span>
                @endif
                @if($user->campus_area)
                    <span class="text-gray-300 dark:text-gray-600">&middot;</span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        {{ $user->campus_area }}
                    </span>
                @endif
            </div>

            {{-- ═══════ Stats Row ═══════ --}}
            <div
                class="flex items-center bg-gray-50 dark:bg-slate-800/50 rounded-card border border-gray-200 dark:border-slate-800 mb-4">
                <div class="flex-1 text-center py-3">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->posts_count }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Karya</p>
                </div>
                <div class="w-px h-8 bg-gray-200 dark:bg-slate-700"></div>
                <div class="flex-1 text-center py-3">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->followers_count }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pengikut</p>
                </div>
                <div class="w-px h-8 bg-gray-200 dark:bg-slate-700"></div>
                <div class="flex-1 text-center py-3">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->following_count }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Mengikuti</p>
                </div>
            </div>

            {{-- ═══════ Action Buttons ═══════ --}}
            <div class="mb-6">
                @if($isOwner)
                    <x-ui.button variant="outlined" full :href="route('profile.edit')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Edit Profil
                    </x-ui.button>
                @else
                    <div class="flex items-center gap-2">
                        @if($isFollowing)
                            <form action="{{ route('profile.unfollow', $user) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <x-ui.button variant="outlined" full type="submit">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Mengikuti
                                </x-ui.button>
                            </form>
                        @else
                            <form action="{{ route('profile.follow', $user) }}" method="POST" class="flex-1">
                                @csrf
                                <x-ui.button variant="primary" full type="submit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                    Ikuti
                                </x-ui.button>
                            </form>
                        @endif
                        <x-ui.button variant="outlined" disabled title="Segera hadir">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                            Pesan
                        </x-ui.button>
                    </div>
                @endif
            </div>

            {{-- ═══════ About Section ═══════ --}}
            <div class="mb-5">
                <h2 class="text-sm font-semibold font-heading text-gray-900 dark:text-white mb-2">Tentang</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ $user->bio ?? 'Belum ada bio.' }}</p>
            </div>

            {{-- ═══════ Skills Section ═══════ --}}
            @if($user->skills->count())
                <div class="mb-6">
                    <h2 class="text-sm font-semibold font-heading text-gray-900 dark:text-white mb-2">Keahlian</h2>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($user->skills as $skill)
                            <x-ui.chip :selected="true">{{ $skill->name }}</x-ui.chip>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ═══════ Social Links ═══════ --}}
            @if($user->socialLinks->count())
                <div class="mb-6">
                    <h2 class="text-sm font-semibold font-heading text-gray-900 dark:text-white mb-2">Media Sosial</h2>
                    <x-social-links :links="$user->socialLinks" />
                </div>
            @endif

            {{-- ═══════ Posts Tab Section ═══════ --}}
            <div x-data="{ activeTab: 'all' }" class="pb-8">
                {{-- Tab Navigation (underline style per GEMINI.md) --}}
                <div class="flex items-center border-b border-gray-200 dark:border-slate-800 mb-4">
                    <button @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'text-primary border-primary' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px">
                        Semua
                    </button>
                    <button @click="activeTab = 'discussion'"
                        :class="activeTab === 'discussion' ? 'text-primary border-primary' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px">
                        Diskusi
                    </button>
                    <button @click="activeTab = 'project'"
                        :class="activeTab === 'project' ? 'text-primary border-primary' : 'text-gray-500 border-transparent hover:text-gray-700'"
                        class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px">
                        Project
                    </button>
                </div>

                {{-- Post List --}}
                <div class="space-y-3">
                    @forelse($posts as $post)
                        <div x-show="activeTab === 'all' || activeTab === '{{ $post->type }}'"
                            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100">
                            @if($post->type === 'project')
                                <x-card.project :post="$post" />
                            @else
                                <x-card.discussion :post="$post" />
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-4xl mb-3">📝</div>
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                {{ $isOwner ? 'Belum ada postingan' : $user->name . ' belum memposting apa pun' }}
                            </h3>
                            <p class="text-xs text-gray-400">
                                {{ $isOwner ? 'Mulai berbagi ide dan project kamu!' : 'Postingan akan muncul di sini.' }}
                            </p>
                            @if($isOwner)
                                <a href="{{ route('post.create') }}"
                                    class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold text-primary hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Buat Postingan
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-6" x-show="activeTab === 'all'">
                    {{ $posts->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection