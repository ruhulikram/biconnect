@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Greeting Card --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark rounded-card p-6 text-white shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl md:text-2xl font-bold font-heading">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-xs md:text-sm opacity-80 mt-1">Kelola platform, pantau laporan, dan jaga kualitas komunitas BiConnect.</p>
        </div>
        <div class="text-4xl hidden sm:block">🛡️</div>
    </div>

    {{-- Stats Row (4 cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 1: Total User --}}
        <div class="bg-white border border-border rounded-card p-5 dark:bg-gray-900 dark:border-gray-800 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total User</p>
                <h3 class="text-2xl font-bold font-heading text-gray-900 dark:text-white mt-1">{{ $stats['total_users'] }}</h3>
                <span class="text-[10px] text-emerald-500 font-semibold flex items-center gap-0.5 mt-0.5">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    Terdaftar aktif
                </span>
            </div>
        </div>

        {{-- Card 2: Post Aktif --}}
        <div class="bg-white border border-border rounded-card p-5 dark:bg-gray-900 dark:border-gray-800 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h12a3 3 0 013 3v12a3 3 0 01-3 3h-12a3 3 0 01-3-3v-12a3 3 0 013-3z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Post Aktif</p>
                <h3 class="text-2xl font-bold font-heading text-gray-900 dark:text-white mt-1">{{ $stats['active_posts'] }}</h3>
                <span class="text-[10px] text-emerald-500 font-semibold flex items-center gap-0.5 mt-0.5">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    Diskusi & Project
                </span>
            </div>
        </div>

        {{-- Card 3: Laporan Pending --}}
        <div class="bg-white border rounded-card p-5 flex items-center gap-4 hover:shadow-md transition-shadow duration-200
                    {{ $stats['pending_reports'] > 0 ? 'border-amber-400 bg-amber-50/20 dark:bg-amber-950/20 dark:border-amber-750' : 'border-border bg-white dark:bg-gray-900 dark:border-gray-800' }}">
            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0
                        {{ $stats['pending_reports'] > 0 ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400' : 'bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan Pending</p>
                <h3 class="text-2xl font-bold font-heading mt-1
                           {{ $stats['pending_reports'] > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-900 dark:text-white' }}">{{ $stats['pending_reports'] }}</h3>
                <span class="text-[10px] font-semibold mt-0.5 {{ $stats['pending_reports'] > 0 ? 'text-amber-500' : 'text-gray-400' }}">
                    {{ $stats['pending_reports'] > 0 ? 'Butuh tinjauan segera' : 'Aman terkendali' }}
                </span>
            </div>
        </div>

        {{-- Card 4: Kolaborasi --}}
        <div class="bg-white border border-border rounded-card p-5 dark:bg-gray-900 dark:border-gray-800 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="w-12 h-12 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kolaborasi</p>
                <h3 class="text-2xl font-bold font-heading text-gray-900 dark:text-white mt-1">{{ $stats['collaborations'] }}</h3>
                <span class="text-[10px] text-emerald-500 font-semibold flex items-center gap-0.5 mt-0.5">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    Minat kolaborasi
                </span>
            </div>
        </div>
    </div>

    {{-- Info Hub Poster Management --}}
    <div class="bg-white border border-border rounded-card shadow-card dark:bg-gray-900 dark:border-gray-800" x-data="{ showForm: false }">
        <div class="p-5 border-b border-border dark:border-gray-800 flex items-center justify-between">
            <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                </svg>
                Poster Information Hub
            </h3>
            <button @click="showForm = !showForm"
                    class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">
                <span x-show="!showForm">+ Tambah Poster</span>
                <span x-show="showForm">Tutup Form</span>
            </button>
        </div>

        {{-- Upload Form --}}
        <div x-show="showForm" x-transition class="p-5 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-950/50" style="display: none;">
            <form action="{{ route('admin.info-hub.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Judul (opsional)</label>
                    <input type="text" name="title" maxlength="255" placeholder="Judul poster..."
                           class="w-full h-10 rounded-input border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Gambar Poster (rasio 3:4, max 5MB)</label>
                    <input type="file" name="poster_image" accept="image/*" required
                           class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-input file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Link Tujuan (opsional)</label>
                    <input type="url" name="poster_link" placeholder="https://..."
                           class="w-full h-10 rounded-input border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-input hover:bg-primary-dark transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Upload Poster
                </button>
            </form>
        </div>

        {{-- Existing Posters List --}}
        <div class="p-5">
            @forelse($posters as $poster)
                <div class="flex items-center gap-4 py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }}">
                    <div class="w-12 h-16 rounded bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                        @if($poster->poster_image)
                            <img src="{{ asset('storage/' . $poster->poster_image) }}" alt="Poster" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $poster->title ?: 'Poster #' . $poster->id }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 truncate">
                            {{ $poster->poster_link ?: 'Tidak ada link' }} ·
                            <span class="{{ $poster->is_active ? 'text-emerald-500' : 'text-red-500' }}">
                                {{ $poster->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span> ·
                            {{ $poster->created_at->format('d M Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <form action="{{ route('admin.info-hub.toggle', $poster) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 transition-colors text-xs">
                                {{ $poster->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.info-hub.destroy', $poster) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus poster ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded hover:bg-red-50 dark:hover:bg-red-950/20 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-sm text-gray-400 dark:text-gray-500">
                    Belum ada poster. Klik "Tambah Poster" untuk mengupload.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Lists Row (2 columns) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Reports --}}
        <div class="bg-white border border-border rounded-card shadow-card dark:bg-gray-900 dark:border-gray-800 flex flex-col">
            <div class="p-5 border-b border-border dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white flex items-center gap-2">
                    <span>Laporan Terbaru</span>
                    @if($stats['pending_reports'] > 0)
                        <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-0.5 rounded-full dark:bg-amber-900/30 dark:text-amber-400">
                            {{ $stats['pending_reports'] }} Pending
                        </span>
                    @endif
                </h3>
                <a href="{{ route('admin.reports') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
                        <tr>
                            <th class="px-5 py-3.5">No</th>
                            <th class="px-5 py-3.5">Jenis</th>
                            <th class="px-5 py-3.5">Deskripsi</th>
                            <th class="px-5 py-3.5">Pelapor</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 dark:divide-gray-800">
                        @forelse($recentReports as $index => $report)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-850 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="text-xs font-semibold px-2 py-1 rounded
                                                 {{ $report->reportable_type === 'App\Models\Post' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400' : 'bg-pink-50 text-pink-600 dark:bg-pink-900/20 dark:text-pink-400' }}">
                                        {{ $report->reportable_type === 'App\Models\Post' ? 'Post' : 'User' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 max-w-[200px] truncate" title="{{ $report->reason }}: {{ $report->detail }}">
                                    <span class="font-medium text-gray-800 dark:text-gray-200 block truncate">{{ $report->reason }}</span>
                                    <span class="text-xs text-gray-400 block truncate">{{ $report->detail ?? '-' }}</span>
                                </td>
                                <td class="px-5 py-3.5 truncate">
                                    {{ $report->reporter?->name ?? 'Anonim' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($report->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    @elseif($report->status === 'handled')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Ditangani
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.reports', ['status' => $report->status]) }}" class="text-xs font-semibold text-primary hover:underline">
                                        Tinjau
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada laporan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="bg-white border border-border rounded-card shadow-card dark:bg-gray-900 dark:border-gray-800 flex flex-col" x-data="userActionTable()">
            <div class="p-5 border-b border-border dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white">User Baru Terdaftar</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
                        <tr>
                            <th class="px-5 py-3.5">User</th>
                            <th class="px-5 py-3.5">Email</th>
                            <th class="px-5 py-3.5">Jurusan</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 dark:divide-gray-800">
                        @forelse($recentUsers as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-850 transition-colors" id="user-row-{{ $user->id }}">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <img src="{{ $user->avatar_url }}" alt="" class="w-8 h-8 rounded-full shrink-0 object-cover border border-gray-100">
                                        <span class="font-semibold text-gray-900 dark:text-white truncate block max-w-[120px]">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-xs truncate max-w-[140px]">{{ $user->email }}</td>
                                <td class="px-5 py-3.5 text-xs truncate max-w-[120px]">{{ $user->program ?? '-' }}</td>
                                <td class="px-5 py-3.5" id="user-status-container-{{ $user->id }}">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-850 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                                    </button>
                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-5 mt-1 w-44 bg-white border border-border rounded-md shadow-lg py-1 z-10 dark:bg-gray-800 dark:border-gray-700 text-left">
                                        <button @click="toggleStatus({{ $user->id }})" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 font-medium">
                                            <span x-text="getStatusLabel({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})">Toggle Status</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                    // Update UI status badge
                    const container = document.getElementById(`user-status-container-${userId}`);
                    if (data.is_active) {
                        container.innerHTML = `
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                                Active
                            </span>
                        `;
                    } else {
                        container.innerHTML = `
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                Inactive
                            </span>
                        `;
                    }
                    this.statuses[userId] = data.is_active;
                    
                    // Show small native notification or toast
                    alert(data.message);
                } else {
                    alert(data.message || 'Gagal mengubah status');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            });
        },
        getStatusLabel(userId, defaultActive) {
            if (this.statuses[userId] === undefined) {
                this.statuses[userId] = defaultActive;
            }
            return this.statuses[userId] ? 'Nonaktifkan' : 'Aktifkan';
        }
    }
}
</script>
@endpush
@endsection
