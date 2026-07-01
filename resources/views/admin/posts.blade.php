@extends('layouts.admin')
@section('title', 'Semua Postingan — Admin')
@section('page_title', 'Semua Postingan')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div>
        <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white">Semua Postingan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Kelola seluruh postingan (diskusi & project) di platform.
        </p>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 rounded-input p-1 w-fit">
        @php
            $currentStatus = request('status', 'all');
            $tabs = [
                'all'      => ['label' => 'Semua', 'count' => $counts['all']],
                'approved' => ['label' => 'Approved', 'count' => $counts['approved']],
                'pending'  => ['label' => 'Pending', 'count' => $counts['pending']],
                'closed'   => ['label' => 'Closed', 'count' => $counts['closed']],
                'rejected' => ['label' => 'Ditolak', 'count' => $counts['rejected']],
            ];
        @endphp
        @foreach($tabs as $key => $tab)
            <a href="{{ route('admin.posts', ['status' => $key]) }}"
               class="px-4 py-2 text-xs font-semibold rounded-input transition-all
                      {{ $currentStatus === $key ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                {{ $tab['label'] }}
                <span class="ml-1.5 text-[10px] opacity-60">({{ $tab['count'] }})</span>
            </a>
        @endforeach
    </div>

    {{-- Posts Table --}}
    <div class="bg-white dark:bg-gray-900 border border-border dark:border-gray-800 rounded-card shadow-card overflow-hidden">
        @if($posts->isEmpty())
            <div class="p-12 text-center">
                <div class="w-10 h-10 mx-auto rounded-lg bg-gray-50 dark:bg-slate-800/60 flex items-center justify-center mb-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Tidak Ada Postingan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Belum ada postingan dengan status ini.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider">Postingan</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider hidden sm:table-cell">Tipe</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider hidden md:table-cell">Pengunggah</th>
                            <th class="text-center px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-center px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider hidden lg:table-cell">Aksi</th>
                            <th class="text-right px-5 py-3 font-semibold text-gray-600 dark:text-gray-400 text-xs uppercase tracking-wider hidden md:table-cell">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($posts as $post)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-5 py-3.5">
                                    <a href="{{ route('post.show', $post) }}" target="_blank"
                                       class="font-semibold text-gray-900 dark:text-white hover:text-primary transition-colors line-clamp-1 max-w-[250px] block">
                                        {{ $post->title ?: \Illuminate\Support\Str::limit($post->body, 60) }}
                                    </a>
                                </td>
                                <td class="px-5 py-3.5 hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold
                                                 {{ $post->type === 'project' ? 'bg-accent-light text-accent dark:bg-accent/10' : 'bg-primary-light text-primary dark:bg-primary/10' }}">
                                        {{ $post->type === 'project' ? 'Project' : 'Diskusi' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 hidden md:table-cell">
                                    <div class="flex items-center gap-2">
                                        <x-ui.avatar :src="$post->user->avatar_url" size="sm" class="!w-6 !h-6" />
                                        <span class="text-gray-700 dark:text-gray-300 text-xs truncate max-w-[100px]">{{ $post->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @php
                                        $statusColors = [
                                            'approved' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
                                            'pending'  => 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400',
                                            'closed'   => 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400',
                                            'rejected' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $statusColors[$post->status] ?? 'bg-gray-100' }}">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                              @style(['background-color: currentColor'])></span>
                                        @if($post->status === 'approved') Approved
                                        @elseif($post->status === 'pending') Pending
                                        @elseif($post->status === 'closed') Closed
                                        @elseif($post->status === 'rejected') Ditolak
                                        @else {{ $post->status }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-center hidden lg:table-cell">
                                    <div class="flex items-center justify-center gap-1">
                                        @if($post->status === 'pending')
                                            <form action="{{ route('admin.approve-project', $post) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 text-[10px] font-semibold text-success bg-success/10 hover:bg-success/20 rounded transition-colors">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reject-project', $post) }}" method="POST"
                                                  onsubmit="return confirm('Yakin menolak project ini?')">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 text-[10px] font-semibold text-danger hover:bg-danger/10 rounded transition-colors">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-gray-400">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-right text-xs text-gray-400 hidden md:table-cell whitespace-nowrap">
                                    {{ $post->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
