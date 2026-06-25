<div x-data="searchModal()"
     x-show="open"
     @open-search.window="openSearch()"
     @keydown.escape.window="closeSearch()"
     @keydown.ctrl.k.prevent="openSearch()"
     @keydown.meta.k.prevent="openSearch()"
     class="fixed inset-0 z-50 flex items-start justify-center pt-[15vh]"
     style="display: none;">

    {{-- Backdrop --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="closeSearch()" class="absolute inset-0 bg-black/50 backdrop-blur-sm">
    </div>

    {{-- Modal Panel --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
         class="relative bg-white dark:bg-gray-900 w-full max-w-lg mx-4 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">

        {{-- Search Input --}}
        <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-200 dark:border-gray-800">
            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" x-ref="searchInput" x-model="query"
                   @input.debounce.300ms="fetchResults()"
                   placeholder="Cari user, post, atau project..."
                   class="flex-1 bg-transparent border-none outline-none text-sm text-gray-900 dark:text-white placeholder-gray-400">
            <kbd class="hidden sm:inline-flex items-center gap-0.5 px-2 py-0.5 rounded text-[10px] font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 dark:text-gray-500 border border-gray-200 dark:border-gray-700">
                <span>ESC</span>
            </kbd>
            <button @click="closeSearch()" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Results Area --}}
        <div class="max-h-[400px] overflow-y-auto">
            {{-- Loading --}}
            <div x-show="loading" class="px-4 py-8 text-center text-sm text-gray-400">
                <div class="animate-pulse">Mencari...</div>
            </div>

            {{-- Results --}}
            <div x-show="!loading && (users.length > 0 || posts.length > 0)" class="divide-y divide-gray-100 dark:divide-gray-800">

                {{-- Users --}}
                <template x-if="users.length > 0">
                    <div>
                        <p class="px-4 py-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-950/50">Pengguna</p>
                        <template x-for="user in users" :key="'u-'+user.id">
                            <a :href="user.url" @click="closeSearch()"
                               class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <img :src="user.avatar_url" alt="" class="w-9 h-9 rounded-full object-cover bg-primary-light" loading="lazy">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="user.name"></p>
                                    <p class="text-xs text-gray-400" x-text="user.program"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </template>

                {{-- Posts --}}
                <template x-if="posts.length > 0">
                    <div>
                        <p class="px-4 py-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-950/50">Postingan</p>
                        <template x-for="post in posts" :key="'p-'+post.id">
                            <a :href="post.url" @click="closeSearch()"
                               class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                     :class="post.type === 'project' ? 'bg-accent-light text-accent' : 'bg-primary-light text-primary'">
                                    <svg x-show="post.type === 'project'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                                    <svg x-show="post.type !== 'project'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.583-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.124-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate" x-text="post.title"></p>
                                    <span class="text-[10px] font-semibold uppercase" :class="post.type === 'project' ? 'text-accent' : 'text-primary'" x-text="post.type === 'project' ? 'Project' : 'Diskusi'"></span>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 ml-auto shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Empty --}}
            <div x-show="!loading && query.length >= 2 && users.length === 0 && posts.length === 0"
                 class="px-4 py-10 text-center">
                <div class="text-3xl mb-3">🔍</div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tidak ada hasil</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Coba kata kunci lain untuk mencari.</p>
            </div>

            {{-- Initial / Short query --}}
            <div x-show="query.length < 2"
                 class="px-4 py-10 text-center">
                <div class="text-3xl mb-3">⌨️</div>
                <p class="text-sm text-gray-400 dark:text-gray-500">Ketik minimal 2 karakter untuk mencari...</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tekan <kbd class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-[10px]">Ctrl+K</kbd> untuk membuka pencarian</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function searchModal() {
    return {
        open: false,
        query: '',
        users: [],
        posts: [],
        loading: false,

        openSearch() {
            this.open = true;
            this.$nextTick(() => {
                if (this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                }
            });
        },

        closeSearch() {
            this.open = false;
            this.query = '';
            this.users = [];
            this.posts = [];
        },

        async fetchResults() {
            if (this.query.trim().length < 2) {
                this.users = [];
                this.posts = [];
                return;
            }

            this.loading = true;
            try {
                const resp = await fetch(`{{ route('search') }}?q=${encodeURIComponent(this.query)}`);
                const data = await resp.json();
                this.users = data.users || [];
                this.posts = data.posts || [];
            } catch (err) {
                console.error('Search error:', err);
                this.users = [];
                this.posts = [];
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
@endpush
