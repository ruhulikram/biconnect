@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-6 py-4" x-data="notificationPage()">

    {{-- ═══════ Top Bar ═══════ --}}
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-lg font-bold font-heading text-gray-900 dark:text-white">Inbox</h1>

        @if($unreadNotifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-primary hover:bg-primary-light dark:hover:bg-primary/10 rounded-input transition-colors"
                        title="Tandai semua sebagai dibaca">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tandai Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- ═══════ Tabs ═══════ --}}
    <div class="flex items-center border-b border-gray-200 dark:border-slate-800 mb-4">
        <button @click="activeTab = 'all'"
                :class="activeTab === 'all' ? 'text-primary border-primary' : 'text-gray-500 border-transparent hover:text-gray-700'"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px">
            Semua
        </button>
        <button @click="activeTab = 'unread'"
                :class="activeTab === 'unread' ? 'text-primary border-primary' : 'text-gray-500 border-transparent hover:text-gray-700'"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px">
            Belum Dibaca
            @if($unreadNotifications->count() > 0)
                <span class="ml-1 inline-flex items-center justify-center min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full px-1">
                    {{ $unreadNotifications->count() }}
                </span>
            @endif
        </button>
    </div>

    {{-- ═══════ Notification List ═══════ --}}
    <div class="space-y-1.5">

        {{-- All Tab --}}
        <div x-show="activeTab === 'all'">
            @forelse($notifications as $notification)
                @include('notifications._item', ['notification' => $notification])
            @empty
                @include('notifications._empty')
            @endforelse
        </div>

        {{-- Unread Tab --}}
        <div x-show="activeTab === 'unread'" style="display: none;">
            @forelse($unreadNotifications as $notification)
                @include('notifications._item', ['notification' => $notification])
            @empty
                @include('notifications._empty', ['message' => 'Tidak ada notifikasi yang belum dibaca'])
            @endforelse
        </div>

    </div>

    {{-- Pagination --}}
    <div class="mt-6" x-show="activeTab === 'all'">
        {{ $notifications->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function notificationPage() {
    return {
        activeTab: 'all'
    };
}
</script>
@endpush
