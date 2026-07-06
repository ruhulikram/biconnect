@extends('layouts.admin')
@section('title', 'Informasi Kampus — Admin')
@section('page_title', 'Informasi Kampus')

@section('content')
<div class="space-y-6" x-data="infoKampusForm()">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white">Informasi Kampus</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola poster dan pengumuman yang tampil di sidebar Information Hub.
            </p>
        </div>
        <button @click="showForm = !showForm"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-semibold rounded-input hover:bg-primary-dark transition-colors active:scale-[0.98]">
            <svg x-show="!showForm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span x-text="showForm ? 'Tutup Form' : 'Tambah Poster'"></span>
        </button>
    </div>

    {{-- Upload/Create Form --}}
    <div x-show="showForm" x-transition
         class="bg-white dark:bg-gray-900 border border-border dark:border-gray-800 rounded-card shadow-card p-6"
         style="display: none;">
        <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Poster Baru
        </h3>
        <form action="{{ route('admin.info-hub.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Judul Poster</label>
                    <input type="text" name="title" maxlength="255" placeholder="Contoh: Info KRS Semester Genap 2025"
                           class="w-full h-10 rounded-input border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Link Tujuan (opsional)</label>
                    <input type="url" name="poster_link" placeholder="https://bsi.ac.id/..."
                           class="w-full h-10 rounded-input border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Gambar Poster</label>
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        {{-- Image Preview --}}
                        <template x-if="imagePreview">
                            <div class="relative w-full h-48 rounded-card overflow-hidden border border-border dark:border-gray-800 bg-gray-50 dark:bg-gray-850">
                                <img :src="imagePreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-2 opacity-0 hover:opacity-100 transition-opacity duration-200">
                                    <button type="button" @click="$refs.fileInput.click()" class="px-3 py-1.5 bg-white text-gray-900 text-xs font-semibold rounded-input hover:bg-gray-100 transition-colors">
                                        Ganti Gambar
                                    </button>
                                    <button type="button" @click="removeImage()" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-input hover:bg-red-700 transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </template>

                        {{-- Drag & Drop Zone --}}
                        <template x-if="!imagePreview">
                            <label 
                                @dragover.prevent="isDragOver = true"
                                @dragleave.prevent="isDragOver = false"
                                @drop.prevent="isDragOver = false; handleDrop($event)"
                                :class="isDragOver ? 'border-primary bg-primary-light/10' : 'border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800'"
                                class="flex flex-col items-center justify-center h-28 border-2 border-dashed rounded-card cursor-pointer hover:border-primary hover:bg-primary-light/10 transition-all">
                                <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Tarik & letakkan gambar di sini, atau klik untuk memilih</span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">Rasio 3:4 (Disarankan), maks 5MB</span>
                                <input type="file" name="poster_image" x-ref="fileInput" @change="handleFileSelect($event)" accept="image/*" required class="hidden">
                            </label>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" @click="showForm = false; removeImage()"
                        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-input transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-5 py-2 bg-primary text-white text-sm font-semibold rounded-input hover:bg-primary-dark transition-colors active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Upload Poster
                </button>
            </div>
        </form>
    </div>

    {{-- Posters Grid --}}
    <div class="bg-white dark:bg-gray-900 border border-border dark:border-gray-800 rounded-card shadow-card">
        <div class="p-5 border-b border-border dark:border-gray-800 flex items-center justify-between">
            <h3 class="text-base font-bold font-heading text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                Daftar Poster
                <span class="text-xs font-normal text-gray-400">({{ $posters->count() }} poster)</span>
            </h3>
        </div>

        @if($posters->isEmpty())
            <div class="p-12 text-center">
                <div class="w-10 h-10 mx-auto rounded-lg bg-gray-50 dark:bg-slate-800 flex items-center justify-center mb-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Belum Ada Poster</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Silakan tambahkan poster baru untuk menampilkan informasi kampus di platform.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-5">
                @foreach($posters as $poster)
                    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card overflow-hidden hover:shadow-md transition-all">
                        {{-- Poster Image --}}
                        <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-900 overflow-hidden relative group">
                            @if($poster->poster_image)
                                <img src="{{ asset('storage/' . $poster->poster_image) }}" alt="{{ $poster->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                </div>
                            @endif

                            {{-- Status badge --}}
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold
                                    {{ $poster->is_active ? 'bg-emerald-500 text-white' : 'bg-gray-500 text-white' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    {{ $poster->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        {{-- Info & Actions --}}
                        <div class="p-3 space-y-2">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $poster->title ?: 'Poster #' . $poster->id }}
                                </h4>
                                @if($poster->poster_link)
                                    <a href="{{ $poster->poster_link }}" target="_blank" class="text-xs text-primary hover:underline truncate block mt-0.5">
                                        {{ Str::limit($poster->poster_link, 40) }}
                                    </a>
                                @endif
                                <p class="text-[10px] text-gray-400 mt-1">{{ $poster->created_at->format('d M Y, H:i') }}</p>
                            </div>

                            <div class="flex items-center gap-1.5 pt-2 border-t border-gray-50 dark:border-gray-700/50">
                                {{-- Toggle Active --}}
                                <form action="{{ route('admin.info-hub.toggle', $poster) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-center px-2 py-1.5 text-[10px] font-semibold rounded transition-colors
                                                   {{ $poster->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-400' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400' }}">
                                        {{ $poster->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                {{-- Delete --}}
                                <form action="{{ route('admin.info-hub.destroy', $poster) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus poster ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="px-2 py-1.5 text-[10px] font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 rounded transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function infoKampusForm() {
    return {
        showForm: false,
        imagePreview: null,
        isDragOver: false,
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            this.previewFile(file);
        },
        
        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file) {
                const input = this.$refs.fileInput;
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                this.previewFile(file);
            }
        },
        
        previewFile(file) {
            if (file && file.type.startsWith('image/')) {
                this.imagePreview = URL.createObjectURL(file);
            } else {
                this.imagePreview = null;
            }
        },
        
        removeImage() {
            this.imagePreview = null;
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
        }
    };
}
</script>
@endpush
@endsection
