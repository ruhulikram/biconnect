@extends('layouts.admin')
@section('title', 'Manajemen Laporan')
@section('page_title', 'Manajemen Laporan')

@section('content')
<div class="space-y-6">

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1 overflow-x-auto pb-2 border-b border-border dark:border-gray-800">
        <a href="{{ route('admin.reports') }}"
           class="shrink-0 px-4 py-2 text-sm font-semibold rounded-md transition-colors
                  {{ is_null($status) ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
            Semua Laporan
        </a>
        <a href="{{ route('admin.reports', ['status' => 'pending']) }}"
           class="shrink-0 px-4 py-2 text-sm font-semibold rounded-md transition-colors flex items-center gap-1.5
                  {{ $status === 'pending' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
            Pending
            @php
                $pendingCount = \App\Models\Report::pending()->count();
            @endphp
            @if($pendingCount > 0)
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $status === 'pending' ? 'bg-white text-primary' : 'bg-amber-500 text-white' }}">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.reports', ['status' => 'handled']) }}"
           class="shrink-0 px-4 py-2 text-sm font-semibold rounded-md transition-colors
                  {{ $status === 'handled' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
            Ditangani
        </a>
        <a href="{{ route('admin.reports', ['status' => 'rejected']) }}"
           class="shrink-0 px-4 py-2 text-sm font-semibold rounded-md transition-colors
                  {{ $status === 'rejected' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
            Ditolak
        </a>
    </div>

    {{-- Reports Table --}}
    <div class="bg-white border border-border rounded-card shadow-card dark:bg-gray-900 dark:border-gray-800 flex flex-col">
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Konten Dilaporkan</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Alasan & Detail</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-150 dark:divide-gray-800">
                    @forelse($reports as $index => $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-850 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $reports->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold px-2.5 py-1 rounded
                                             {{ $report->reportable_type === 'App\Models\Post' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400' : 'bg-pink-50 text-pink-600 dark:bg-pink-900/20 dark:text-pink-400' }}">
                                    {{ $report->reportable_type === 'App\Models\Post' ? 'Postingan' : 'Pengguna' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($report->reportable)
                                    @if($report->reportable_type === 'App\Models\Post')
                                        <a href="{{ route('post.show', $report->reportable_id) }}" class="text-primary hover:underline font-semibold text-xs block max-w-[200px] truncate" target="_blank">
                                            {{ $report->reportable->title ?? 'Lihat Postingan' }}
                                        </a>
                                        <span class="text-[10px] text-gray-400 block truncate">Oleh: {{ $report->reportable->user->name ?? 'Anonim' }}</span>
                                    @else
                                        <a href="{{ route('profile.show.user', $report->reportable_id) }}" class="text-primary hover:underline font-semibold text-xs block max-w-[200px] truncate" target="_blank">
                                            {{ $report->reportable->name ?? 'Lihat Profil' }}
                                        </a>
                                        <span class="text-[10px] text-gray-400 block truncate">{{ $report->reportable->email }}</span>
                                    @endif
                                @else
                                    <span class="text-xs text-red-500 font-semibold italic">Konten telah dihapus/nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 truncate max-w-[150px]">
                                <span class="font-medium text-gray-900 dark:text-white block truncate">{{ $report->reporter->name ?? 'Anonim' }}</span>
                                <span class="text-[10px] text-gray-400 block truncate">{{ $report->reporter->email ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800 dark:text-gray-200 block text-xs">{{ $report->reason }}</span>
                                @if($report->detail)
                                    <span class="text-xs text-gray-400 block max-w-[250px] whitespace-normal mt-0.5 leading-relaxed">{{ $report->detail }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($report->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @elseif($report->status === 'handled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Ditangani
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($report->status === 'pending')
                                    <div class="flex items-center justify-end gap-1.5">
                                        <form action="{{ route('admin.handle-report', $report) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="handled">
                                            <button type="submit" class="text-xs font-bold text-white bg-emerald-500 hover:bg-emerald-600 px-2.5 py-1.5 rounded shadow-sm transition-colors">
                                                Tangani
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.handle-report', $report) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-750 px-2.5 py-1.5 rounded transition-colors">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Selesai diproses</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada laporan yang sesuai kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-border dark:border-gray-800">
                {{ $reports->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
