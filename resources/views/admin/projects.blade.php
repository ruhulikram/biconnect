@extends('layouts.admin')
@section('title', 'Project Pending — Admin')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white">Project Pending</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Tinjau dan setujui project yang diunggah oleh mahasiswa.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-primary hover:text-primary-dark transition-colors font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Projects Table --}}
    @if($projects->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-card p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Tidak Ada Project Pending</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Semua project sudah ditinjau.</p>
        </div>
    @else
        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700">
                        <tr>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Project</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400 hidden sm:table-cell">Pengunggah</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400 hidden md:table-cell">Kampus</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400 hidden lg:table-cell">Tanggal</th>
                            <th class="text-right px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                        @foreach($projects as $project)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-primary-light/10 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-4.5 h-4.5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('post.show', $project) }}" target="_blank"
                                               class="font-semibold text-gray-900 dark:text-white hover:text-primary transition-colors truncate block max-w-[200px] sm:max-w-[300px]">
                                                {{ $project->title }}
                                            </a>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                @if($project->project_type)
                                                    <span class="inline-flex px-1.5 py-px text-[10px] font-medium rounded bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400">
                                                        {{ $project->project_type }}
                                                    </span>
                                                @endif
                                                @if($project->skills->isNotEmpty())
                                                    <span class="text-[10px] text-gray-400">
                                                        {{ $project->skills->take(2)->pluck('name')->join(', ') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 hidden sm:table-cell">
                                    <div class="flex items-center gap-2">
                                        <x-ui.avatar :src="$project->user->avatar_url" size="sm" />
                                        <span class="text-gray-700 dark:text-gray-300 truncate max-w-[120px]">
                                            {{ $project->user->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 hidden md:table-cell">
                                    {{ $project->campus_area ?? '—' }}
                                </td>
                                <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 hidden lg:table-cell whitespace-nowrap">
                                    {{ $project->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Reject --}}
                                        <form action="{{ route('admin.reject-project', $project) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menolak project ini?')">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium text-danger hover:bg-danger/10 rounded-input transition-colors">
                                                Tolak
                                            </button>
                                        </form>
                                        {{-- Approve --}}
                                        <form action="{{ route('admin.approve-project', $project) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium text-success bg-success/10 hover:bg-success/20 rounded-input transition-colors">
                                                Setujui
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($projects->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-slate-800">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
