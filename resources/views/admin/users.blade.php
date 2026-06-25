@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Controls Row --}}
    <div class="bg-white border border-border rounded-card p-4 dark:bg-gray-900 dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        {{-- Search Form --}}
        <form action="{{ route('admin.users') }}" method="GET" class="w-full md:max-w-md flex items-center gap-2">
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, NIM..."
                       class="w-full h-10 pl-10 pr-4 rounded-input border border-border bg-white text-sm placeholder-gray-455 text-gray-900 focus:outline-none focus:border-primary focus:shadow-focus dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-500">
            </div>
            <button type="submit" class="inline-flex items-center justify-center font-medium rounded-input bg-primary text-white hover:bg-primary-dark transition-colors px-4 h-10 text-sm">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center font-medium rounded-input border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors px-3 h-10 text-sm dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                    Reset
                </a>
            @endif
        </form>

        <div class="text-xs text-gray-400">
            Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white border border-border rounded-card shadow-card dark:bg-gray-900 dark:border-gray-800 flex flex-col" x-data="userActionPanel()">
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Fakultas / Jurusan</th>
                        <th class="px-6 py-4">Kampus</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-150 dark:divide-gray-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-850 transition-colors" id="user-row-{{ $user->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <img src="{{ $user->avatar_url }}" alt="" class="w-9 h-9 rounded-full shrink-0 object-cover border border-gray-100 dark:border-gray-800">
                                    <div class="min-w-0">
                                        <span class="font-bold text-gray-900 dark:text-white block truncate">{{ $user->name }}</span>
                                        @if($user->is_admin)
                                            <span class="inline-flex text-[9px] uppercase tracking-widest bg-primary/10 text-primary border border-primary/20 font-bold px-1.5 rounded">Admin</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs">{{ $user->nim ?? '-' }}</td>
                            <td class="px-6 py-4 text-xs">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-xs">
                                <div class="max-w-[200px] truncate">
                                    {{ $user->program ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs">{{ $user->campus_area ?? '-' }}</td>
                            <td class="px-6 py-4" id="user-status-container-{{ $user->id }}">
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
                            <td class="px-6 py-4 text-right relative" x-data="{ open: false }">
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
                                     class="absolute right-6 mt-1 w-44 bg-white border border-border rounded-md shadow-lg py-1 z-10 dark:bg-gray-800 dark:border-gray-700 text-left">
                                    <button @click="toggleStatus({{ $user->id }})" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 font-medium">
                                        <span x-text="getStatusLabel({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})">Toggle Status</span>
                                    </button>
                                    <a href="{{ route('profile.show.user', $user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 font-medium">
                                        Lihat Profil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada pengguna yang cocok dengan kriteria pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-border dark:border-gray-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function userActionPanel() {
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
