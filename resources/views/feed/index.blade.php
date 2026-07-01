@extends('layouts.app')
@section('title', 'Feed')

@php
    $selectedSkillIds = request()->filled('skills')
        ? (is_array(request('skills')) ? request('skills') : explode(',', request('skills')))
        : [];
    $selectedSkills = \App\Models\Skill::whereIn('id', $selectedSkillIds)
        ->get()
        ->map(fn($s) => ['id' => $s->id, 'name' => $s->name]);

    // Fetch posters for info hub (graceful fallback until Phase 4 migration runs)
    $infoPosters = class_exists(\App\Models\InfoHub::class)
        ? \App\Models\InfoHub::where('is_active', true)->latest()->get()
        : collect();

    // Prepare query vars for tabs
    $currentType = request('type');
    $semuaQuery = request()->query();
    unset($semuaQuery['type'], $semuaQuery['page']);
    $diskusiQuery = array_merge(request()->query(), ['type' => 'discussion']);
    unset($diskusiQuery['page']);
    $projectQuery = array_merge(request()->query(), ['type' => 'project']);
    unset($projectQuery['page']);
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 lg:py-6">

    {{-- ===== DESKTOP 3-COLUMN LAYOUT ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr_280px] gap-6">

        {{-- ══ LEFT: Desktop Filter Panel ══ --}}
        <aside class="hidden lg:block">
            <x-feed-filters
                :campusAreas="$campusAreas ?? []"
                :allSkills="$allSkills ?? collect([])"
                :selectedSkills="$selectedSkills" />
        </aside>

        {{-- ══ CENTER: Feed Content ══ --}}
        <div class="min-w-0">

            {{-- Tab Bar + Filter button (mobile) --}}
            <div class="sticky top-14 z-30 bg-surface/95 dark:bg-gray-950/95 backdrop-blur-sm pt-2 mb-5 border-b border-gray-200 dark:border-gray-800 flex items-end justify-between transition-colors">
                <div class="flex items-center gap-1 overflow-x-auto no-scrollbar -mb-[1px]">
                    <a href="{{ route('feed.index', $semuaQuery) }}"
                       class="shrink-0 px-4 pb-2.5 text-sm font-semibold transition-all duration-150 border-b-2
                              {{ is_null($currentType) ? 'text-primary border-primary dark:text-primary-light dark:border-primary' : 'text-gray-500 hover:text-gray-800 border-transparent dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('feed.index', $diskusiQuery) }}"
                       class="shrink-0 px-4 pb-2.5 text-sm font-semibold transition-all duration-150 border-b-2
                              {{ $currentType === 'discussion' ? 'text-primary border-primary dark:text-primary-light dark:border-primary' : 'text-gray-500 hover:text-gray-800 border-transparent dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Diskusi
                    </a>
                    <a href="{{ route('feed.index', $projectQuery) }}"
                       class="shrink-0 px-4 pb-2.5 text-sm font-semibold transition-all duration-150 border-b-2
                              {{ $currentType === 'project' ? 'text-primary border-primary dark:text-primary-light dark:border-primary' : 'text-gray-500 hover:text-gray-800 border-transparent dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Project
                    </a>
                </div>

                {{-- Filter button — mobile only --}}
                <div class="lg:hidden shrink-0 ml-4 pb-1.5">
                    <button id="filter-btn" @click="$dispatch('open-filter')"
                            class="flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300
                                   border border-gray-300 dark:border-gray-800 rounded-pill hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-150 select-none cursor-pointer">
                        <x-ui.icon name="filter" class="w-4 h-4 text-gray-400 dark:text-gray-500" stroke-width="2" />
                        <span>Filter</span>
                        @if(request()->anyFilled(['campus_area', 'project_type', 'skills']))
                            <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                        @endif
                    </button>
                </div>
            </div>

            {{-- Active Filter Tags Indicator --}}
            @if(request()->anyFilled(['campus_area', 'project_type', 'skills']))
                <div class="flex flex-wrap items-center gap-2 mb-4 bg-gray-50 dark:bg-gray-900/40 p-3 rounded-lg border border-gray-200/60 dark:border-gray-800/40">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Filter Aktif:</span>
                    @if(request('campus_area'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-pill text-[10px] font-medium bg-gray-200/60 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            Kampus: {{ request('campus_area') }}
                        </span>
                    @endif
                    @if(request('project_type'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-pill text-[10px] font-medium bg-gray-200/60 text-gray-700 dark:bg-gray-800 dark:text-gray-300 uppercase">
                            Kategori: {{ request('project_type') }}
                        </span>
                    @endif
                    @if(request('skills'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-pill text-[10px] font-medium bg-gray-200/60 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            Skills: {{ count(explode(',', request('skills'))) }} dipilih
                        </span>
                    @endif
                    <a href="{{ route('feed.index', $currentType ? ['type' => $currentType] : []) }}"
                       class="text-xs text-primary hover:text-primary-dark font-semibold transition-colors ml-auto">
                        Bersihkan
                    </a>
                </div>
            @endif

            {{-- "Buat Project" button above feed (visible on all breakpoints) --}}
            <div class="mb-4">
                <x-ui.button variant="primary" size="md" :href="route('post.create')" class="w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Buat Project / Diskusi
                </x-ui.button>
            </div>

            {{-- Feed List --}}
            <div class="space-y-4">
                @forelse($posts as $post)
                    @if($post->type === 'project')
                        <x-card.project :post="$post" />
                    @else
                        <x-card.discussion :post="$post" />
                    @endif
                @empty
                    {{-- Empty state --}}
                    <div class="text-center py-20 px-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-card shadow-card flex flex-col items-center">
                        <div class="w-18 h-18 bg-primary-light dark:bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-2">Belum Ada Postingan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm leading-relaxed mb-6">
                            Tidak ditemukan postingan yang cocok dengan kriteria filter Anda. Jadilah yang pertama membagikan diskusi atau project!
                        </p>
                        <x-ui.button variant="primary" size="md" :href="route('post.create')">
                            Buat Post Baru
                        </x-ui.button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- ══ RIGHT: Information Hub ══ --}}
        <aside class="hidden lg:block">
            <x-info-hub :posters="$infoPosters" />
        </aside>

    </div>
</div>

{{-- FAB (Floating Action Button) — mobile only (hidden on desktop since we have the button above feed) --}}
<a href="{{ route('post.create') }}" title="Buat Post Baru" aria-label="Buat Post Baru"
   class="lg:hidden fixed bottom-20 right-5 w-14 h-14 bg-accent rounded-full shadow-fab hover:shadow-xl hover:scale-105 active:scale-95
          flex items-center justify-center text-white transition-all duration-200 z-30">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
    </svg>
</a>

{{-- Filter Bottom Sheet — mobile only (included but dismisses itself via Alpine) --}}
<div class="lg:hidden">
    @include('components.modals.filter-sheet')
</div>
@endsection
