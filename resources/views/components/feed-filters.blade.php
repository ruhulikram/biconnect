@props([
    'campusAreas' => [],
    'allSkills'   => [],
    'selectedSkills' => [],
])

<div x-data="desktopFilters()" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-card p-5 sticky top-20">
    <h3 class="text-sm font-bold font-heading text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
        </svg>
        Filter
        <button @click="resetAll" class="ml-auto text-[10px] font-normal text-primary hover:underline" x-show="hasActiveFilters">
            Reset
        </button>
    </h3>

    <div class="space-y-5">

        {{-- 1. Post Type --}}
        <div class="space-y-1.5">
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Tipe Post</label>
            <div class="grid grid-cols-3 bg-gray-50 dark:bg-gray-950 p-1 rounded-lg border border-gray-200 dark:border-gray-800">
                <button type="button" @click="type = ''; applyFilters()"
                        :class="type === '' ? 'bg-white dark:bg-gray-800 text-primary shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                        class="py-1.5 text-xs font-medium rounded-md transition-all">
                    Semua
                </button>
                <button type="button" @click="type = 'discussion'; applyFilters()"
                        :class="type === 'discussion' ? 'bg-white dark:bg-gray-800 text-primary shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                        class="py-1.5 text-xs font-medium rounded-md transition-all">
                    Diskusi
                </button>
                <button type="button" @click="type = 'project'; applyFilters()"
                        :class="type === 'project' ? 'bg-white dark:bg-gray-800 text-primary shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                        class="py-1.5 text-xs font-medium rounded-md transition-all">
                    Project
                </button>
            </div>
        </div>

        {{-- 2. Campus Area --}}
        <div class="space-y-1.5">
            <label for="df_campus" class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Area Kampus</label>
            <select id="df_campus" x-model="campusArea" @change="applyFilters()"
                    class="w-full h-9 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-input px-3 text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">
                <option value="">Semua Area</option>
                @foreach($campusAreas as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- 3. Project Category (only when project or all) --}}
        <div class="space-y-1.5" x-show="type === '' || type === 'project'">
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Kategori</label>
            <div class="flex flex-wrap gap-1.5">
                @foreach(['paid' => 'Paid', 'unpaid' => 'Sukarela', 'portfolio' => 'Portfolio'] as $val => $label)
                    <button type="button" @click="projectType = (projectType === '{{ $val }}' ? '' : '{{ $val }}'); applyFilters()"
                            :class="projectType === '{{ $val }}' ? 'bg-primary-light text-primary border-primary/20 dark:bg-primary/10 dark:text-primary-light' : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-transparent hover:bg-gray-100 dark:hover:bg-gray-700'"
                            class="px-2.5 py-1 rounded-pill text-[10px] font-medium border transition-colors">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 4. Skills --}}
        <div class="space-y-1.5">
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Keahlian</label>
            <div class="relative" @click.outside="skillDropdown = false">
                <input type="text" x-model="skillSearch" @focus="skillDropdown = true" @input="skillDropdown = true"
                       placeholder="Cari skill..."
                       class="w-full h-9 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-input px-3 text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20">

                {{-- Dropdown --}}
                <div x-show="skillDropdown && filteredSkills().length > 0" x-transition
                     class="absolute left-0 right-0 mt-1 max-h-36 overflow-y-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-30 text-xs"
                     style="display: none;">
                    <template x-for="skill in filteredSkills()" :key="skill.id">
                        <button type="button" @click="addSkill(skill); skillSearch = ''; skillDropdown = false; applyFilters()"
                                class="w-full text-left px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            <span x-text="skill.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Selected skill chips --}}
            <div class="flex flex-wrap gap-1 mt-2" x-show="selectedSkills.length > 0">
                <template x-for="skill in selectedSkills" :key="skill.id">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-pill text-[10px] font-medium bg-primary-light text-primary border border-primary/20 dark:bg-primary/10 dark:border-primary/30">
                        <span x-text="skill.name"></span>
                        <button type="button" @click="removeSkill(skill.id); applyFilters()" class="text-current opacity-60 hover:opacity-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </span>
                </template>
            </div>
        </div>

        {{-- 5. Sort --}}
        <div class="space-y-1.5">
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Urutkan</label>
            <div class="space-y-1">
                <label class="flex items-center gap-2 p-2 border border-gray-200 dark:border-gray-800 rounded-input cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                    <input type="radio" name="df_sort" value="latest" x-model="sortBy" @change="applyFilters()" class="text-primary focus:ring-primary/20">
                    <span class="text-xs text-gray-700 dark:text-gray-300">Terbaru</span>
                </label>
                <label class="flex items-center gap-2 p-2 border border-gray-200 dark:border-gray-800 rounded-input cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                    <input type="radio" name="df_sort" value="popular" x-model="sortBy" @change="applyFilters()" class="text-primary focus:ring-primary/20">
                    <span class="text-xs text-gray-700 dark:text-gray-300">Populer</span>
                </label>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function desktopFilters() {
    return {
        type: '{{ request('type', '') }}',
        campusArea: '{{ request('campus_area', '') }}',
        projectType: '{{ request('project_type', '') }}',
        sortBy: '{{ request('sort', 'latest') }}',
        skillSearch: '',
        skillDropdown: false,
        selectedSkills: @json($selectedSkills),
        allSkills: @json($allSkills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->toArray()),

        get hasActiveFilters() {
            return this.type || this.campusArea || this.projectType || this.selectedSkills.length > 0;
        },

        filteredSkills() {
            if (!this.skillSearch) return [];
            const q = this.skillSearch.toLowerCase();
            return this.allSkills.filter(s =>
                s.name.toLowerCase().includes(q) &&
                !this.selectedSkills.some(sel => sel.id === s.id)
            );
        },

        addSkill(skill) {
            if (!this.selectedSkills.some(s => s.id === skill.id)) {
                this.selectedSkills.push(skill);
            }
        },

        removeSkill(id) {
            this.selectedSkills = this.selectedSkills.filter(s => s.id !== id);
        },

        resetAll() {
            this.type = '';
            this.campusArea = '';
            this.projectType = '';
            this.sortBy = 'latest';
            this.selectedSkills = [];
            this.skillSearch = '';
            this.applyFilters();
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.type) params.set('type', this.type);
            if (this.campusArea) params.set('campus_area', this.campusArea);
            if (this.projectType) params.set('project_type', this.projectType);
            if (this.sortBy && this.sortBy !== 'latest') params.set('sort', this.sortBy);
            if (this.selectedSkills.length > 0) {
                params.set('skills', this.selectedSkills.map(s => s.id).join(','));
            }

            const url = '{{ route('feed.index') }}' + (params.toString() ? '?' + params.toString() : '');
            window.location.href = url;
        }
    };
}
</script>
@endpush
