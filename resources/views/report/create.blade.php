@extends('layouts.app')
@section('title', $type === 'post' ? 'Laporkan Postingan' : 'Laporkan Pengguna')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-6 py-4" x-data="reportForm()">

    {{-- ═══════ Top Bar ═══════ --}}
    <div class="flex items-center gap-3 mb-6">
        <button onclick="history.back()"
                class="p-1.5 rounded-input hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </button>
        <h1 class="text-lg font-bold font-heading text-gray-900 dark:text-white">
            {{ $type === 'post' ? 'Laporkan Postingan' : 'Laporkan Pengguna' }}
        </h1>
    </div>

    {{-- ═══════ Subtext ═══════ --}}
    <div class="mb-6">
        <h2 class="text-base font-bold text-gray-900 dark:text-white mb-1">Kenapa kamu melaporkan ini?</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Laporan kamu bersifat anonim. Kami akan meninjau dan mengambil tindakan yang sesuai.
        </p>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
            Target: <span class="font-medium text-gray-600 dark:text-gray-300">{{ $targetName }}</span>
        </p>
    </div>

    <form action="{{ route('report.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reportable_type" value="{{ $type }}">
        <input type="hidden" name="reportable_id" value="{{ $id }}">

        {{-- ═══════ Reason Radio List ═══════ --}}
        <div class="space-y-2 mb-6">
            @php
                $reasons = [
                    'Spam atau promosi berlebihan' => 'Konten iklan tidak relevan',
                    'Konten tidak relevan dengan kampus' => 'Tidak sesuai platform akademik',
                    'Pelecehan atau ujaran kebencian' => 'Menyerang individu atau kelompok',
                    'Konten dewasa / tidak pantas' => 'Tidak sesuai komunitas kampus',
                    'Penipuan / informasi menyesatkan' => 'Informasi palsu atau menipu',
                    'Lainnya' => 'Alasan lain',
                ];
            @endphp

            @foreach($reasons as $label => $description)
                <label class="flex items-start gap-3 px-4 py-3.5 bg-white dark:bg-slate-900 border rounded-card cursor-pointer transition-all duration-150 hover:border-gray-300 dark:hover:border-slate-600"
                       :class="selectedReason === '{{ $label }}' ? 'border-primary ring-1 ring-primary/20 bg-primary-light/30 dark:bg-primary/5' : 'border-gray-200 dark:border-slate-800'">
                    <input type="radio" name="reason" value="{{ $label }}"
                           x-model="selectedReason"
                           class="mt-0.5 w-4 h-4 text-primary border-gray-300 focus:ring-primary/30 dark:border-slate-600 dark:bg-slate-800">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium transition-colors"
                           :class="selectedReason === '{{ $label }}' ? 'text-primary' : 'text-gray-900 dark:text-white'">
                            {{ $label }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $description }}</p>
                    </div>
                </label>
            @endforeach

            @error('reason')
                <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ═══════ Detail Textarea ═══════ --}}
        <div class="mb-6">
            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Detail tambahan (opsional)</label>
            <textarea name="detail"
                      rows="3"
                      maxlength="500"
                      x-model="detail"
                      placeholder="Jelaskan lebih lanjut jika perlu..."
                      class="w-full rounded-input border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-3 text-sm placeholder-gray-400 text-gray-900 dark:text-gray-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus resize-none"></textarea>
            <p class="text-xs text-gray-400 text-right mt-1" x-text="detail.length + '/500'"></p>
        </div>

        {{-- ═══════ Submit Button (Sticky Bottom) ═══════ --}}
        <div class="sticky bottom-20 md:bottom-0 pb-4 pt-3 bg-gradient-to-t from-surface via-surface dark:from-gray-950 dark:via-gray-950">
            <button type="submit"
                    x-bind:disabled="!selectedReason"
                    class="w-full inline-flex items-center justify-center gap-2 font-semibold rounded-input transition-all duration-150 px-5 py-3 text-sm h-12
                           bg-primary text-white hover:bg-primary-dark disabled:opacity-40 disabled:cursor-not-allowed shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"/>
                </svg>
                Kirim Laporan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function reportForm() {
    return {
        selectedReason: '{{ old('reason', '') }}',
        detail: '{{ old('detail', '') }}'
    };
}
</script>
@endpush
