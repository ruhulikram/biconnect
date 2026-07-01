@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-900 dark:text-white">
                Dashboard Admin
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola pengguna, tinjau project pending, dan pantau aktivitas platform BiConnect.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 border border-gray-250 dark:border-slate-800/80 bg-white dark:bg-slate-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800 text-xs font-semibold rounded-lg transition-colors cursor-pointer shadow-sm">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z"/></svg>
                Semua Postingan
            </a>
            <a href="{{ route('admin.info-kampus') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 border border-gray-250 dark:border-slate-800/80 bg-white dark:bg-slate-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800 text-xs font-semibold rounded-lg transition-colors cursor-pointer shadow-sm">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                Info Kampus
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Users --}}
        <a href="{{ route('admin.users') }}" class="group bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl p-5 hover:border-gray-300 dark:hover:border-slate-700 hover:shadow-sm transition-all duration-200 cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-850 flex items-center justify-center text-gray-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
            <p class="text-2xl font-bold font-heading text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['total_users']) }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Total Pengguna</p>
        </a>

        {{-- Active Posts --}}
        <a href="{{ route('admin.posts', ['status' => 'approved']) }}" class="group bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl p-5 hover:border-gray-300 dark:hover:border-slate-700 hover:shadow-sm transition-all duration-200 cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-850 flex items-center justify-center text-gray-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z"/></svg>
                </div>
                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
            <p class="text-2xl font-bold font-heading text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['active_posts']) }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Post Aktif</p>
        </a>

        {{-- Pending Projects --}}
        <a href="{{ route('admin.projects') }}" class="group bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl p-5 hover:border-gray-300 dark:hover:border-slate-700 hover:shadow-sm transition-all duration-200 cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-850 flex items-center justify-center text-gray-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                @if($stats['pending_projects'] > 0)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-[10px] font-semibold border border-amber-100 dark:border-amber-900/50">
                        {{ $stats['pending_projects'] }} Baru
                    </span>
                @else
                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                @endif
            </div>
            <p class="text-2xl font-bold font-heading text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['pending_projects']) }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Project Pending</p>
        </a>

        {{-- Collaborations --}}
        <div class="group bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl p-5 hover:border-gray-300 dark:hover:border-slate-700 hover:shadow-sm transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-slate-850 flex items-center justify-center text-gray-500 dark:text-slate-400 group-hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold font-heading text-gray-900 dark:text-white tracking-tight">{{ number_format($stats['collaborations']) }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Kolaborasi</p>
        </div>
    </div>

    {{-- Main Content Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Pending Projects + InfoHub --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Pending Projects Queue --}}
            <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white">Antrian Persetujuan Project</h3>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500">Project yang menunggu tinjauan admin</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.projects') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary-dark transition-colors cursor-pointer shadow-sm shadow-primary/10">
                        Tinjau Semua
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
                @if($stats['pending_projects'] > 0)
                    @php
                        $pendingProjects = \App\Models\Post::with('user')
                            ->where('type', 'project')
                            ->where('status', 'pending')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    <div class="divide-y divide-gray-100 dark:divide-slate-800">
                        @foreach($pendingProjects as $project)
                            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <img src="{{ $project->user->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $project->title }}</p>
                                        <p class="text-[11px] text-gray-400 dark:text-slate-500">{{ $project->user->name }} &middot; {{ $project->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0 ml-4">
                                    <form action="{{ route('admin.reject-project', $project) }}" method="POST"
                                          onsubmit="return confirm('Yakin menolak?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-[11px] font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition-colors cursor-pointer">Tolak</button>
                                    </form>
                                    <form action="{{ route('admin.approve-project', $project) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-[11px] font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors cursor-pointer shadow-sm">Setujui</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="w-10 h-10 mx-auto rounded-lg bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Tidak Ada Antrian Persetujuan</p>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Semua pengajuan project telah selesai ditinjau.</p>
                    </div>
                @endif
            </div>

            {{-- InfoHub Quick Management --}}
            <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl shadow-sm overflow-hidden" x-data="{ showForm: false }">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white">Informasi Kampus</h3>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500">Poster yang tampil di sidebar pengguna</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <a href="{{ route('admin.info-kampus') }}" class="text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors cursor-pointer">Lihat Semua</a>
                        <button @click="showForm = !showForm"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-[11px] font-semibold rounded-lg hover:bg-primary-dark transition-colors cursor-pointer">
                            <span x-show="!showForm">+ Tambah</span>
                            <span x-show="showForm" x-cloak>Tutup</span>
                        </button>
                    </div>
                </div>

                {{-- Quick Upload Form --}}
                <div x-show="showForm" x-transition x-cloak class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-gray-950/30">
                    <form action="{{ route('admin.info-hub.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-end gap-3">
                        @csrf
                        <div class="flex-1 w-full">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Judul</label>
                            <input type="text" name="title" maxlength="255" placeholder="Judul poster..."
                                   class="w-full h-9 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Link (opsional)</label>
                            <input type="url" name="poster_link" placeholder="https://..."
                                   class="w-full h-9 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Gambar</label>
                            <input type="file" name="poster_image" accept="image/*" required
                                   class="w-full text-[11px] text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark">
                        </div>
                        <button type="submit"
                                class="shrink-0 inline-flex items-center gap-1 px-4 h-9 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary-dark transition-colors cursor-pointer shadow-sm shadow-primary/10">
                            Upload
                        </button>
                    </form>
                </div>

                {{-- Posters List --}}
                @if($posters->isNotEmpty())
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3 p-4">
                        @foreach($posters->take(5) as $poster)
                            <div class="relative group rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 aspect-[3/4]">
                                @if($poster->poster_image)
                                    <img src="{{ asset('storage/' . $poster->poster_image) }}" alt="{{ $poster->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                    <p class="text-[10px] font-semibold text-white truncate">{{ $poster->title ?: 'Poster #'.$poster->id }}</p>
                                </div>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full {{ $poster->is_active ? 'bg-emerald-400' : 'bg-gray-450' }} ring-1 ring-white/50"></span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <p class="text-xs text-gray-400 dark:text-slate-500">Belum ada poster. Klik <strong>+ Tambah</strong> untuk upload.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Recent Users --}}
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800/80 rounded-xl shadow-sm overflow-hidden" x-data="userActionTable()">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 dark:bg-sky-950/40 flex items-center justify-center">
                        <svg class="w-4 h-4 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white">User Baru</h3>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500">{{ $stats['total_users'] }} total terdaftar</p>
                    </div>
                </div>
                <a href="{{ route('admin.users') }}" class="text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors cursor-pointer">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-slate-800">
                @forelse($recentUsers->take(8) as $user)
                    <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-slate-800/20 transition-colors" id="user-row-{{ $user->id }}">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="relative">
                                <x-ui.avatar :src="$user->avatar_url" size="sm" />
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full ring-2 ring-white dark:ring-slate-900 {{ $user->is_active ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                <p class="text-[11px] text-gray-400 dark:text-slate-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 ml-3">
                            <span id="user-status-container-{{ $user->id }}"
                                  class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                         {{ $user->is_active ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-450' : 'bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-450' }}">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: currentColor"></span>
                                {{ $user->is_active ? 'Active' : 'Off' }}
                            </span>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="p-1 rounded-lg hover:bg-gray-150 dark:hover:bg-slate-800 text-gray-400 cursor-pointer">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                                </button>
                                <div x-show="open" x-transition
                                     class="absolute right-0 mt-1 w-40 bg-white dark:bg-slate-900 border border-gray-250 dark:border-slate-850 rounded-lg shadow-xl py-1 z-20">
                                    <button @click="toggleStatus({{ $user->id }})" class="w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800 font-medium cursor-pointer">
                                        <span x-text="getStatusLabel({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-xs text-gray-400 dark:text-slate-500">Belum ada pengguna terdaftar.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
function userActionTable() {
    return {
        statuses: {},
        toggleStatus(userId) {
            fetch(`/admin/pengguna/${userId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const container = document.getElementById(`user-status-container-${userId}`);
                    if (data.is_active) {
                        container.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400';
                        container.innerHTML = '<span class="w-1.5 h-1.5 rounded-full" style="background-color: currentColor"></span> Active';
                    } else {
                        container.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400';
                        container.innerHTML = '<span class="w-1.5 h-1.5 rounded-full" style="background-color: currentColor"></span> Off';
                    }
                    this.statuses[userId] = data.is_active;
                }
            })
            .catch(err => console.error(err));
        },
        getStatusLabel(userId, defaultActive) {
            if (this.statuses[userId] === undefined) this.statuses[userId] = defaultActive;
            return this.statuses[userId] ? 'Nonaktifkan' : 'Aktifkan';
        }
    }
}
</script>
@endpush
@endsection
