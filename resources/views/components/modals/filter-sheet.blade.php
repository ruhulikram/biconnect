@php
    $selectedSkillIds = request()->filled('skills') 
        ? (is_array(request('skills')) ? request('skills') : explode(',', request('skills'))) 
        : [];
    $selectedSkills = \App\Models\Skill::whereIn('id', $selectedSkillIds)
        ->get()
        ->map(fn($s) => ['id' => $s->id, 'name' => $s->name])
        ->toArray();
@endphp

<div x-data="filterSheet()"
     @open-filter.window="open = true"
     x-show="open"
     class="fixed inset-0 z-50 flex items-end justify-center"
     style="display: none;">
     
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="absolute inset-0 bg-black/40 backdrop-blur-sm">
    </div>

    {{-- Slide-up Sheet Panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="relative bg-white dark:bg-gray-900 w-full max-w-xl rounded-t-2xl shadow-xl flex flex-col max-h-[85vh] z-10">
         
        {{-- Handle bar for aesthetics --}}
        <div class="flex justify-center py-3">
            <div class="w-12 h-1.5 bg-gray-200 dark:bg-gray-800 rounded-full cursor-pointer" @click="open = false"></div>
        </div>

        {{-- Header --}}
        <div class="px-6 pb-4 border-b border-border dark:border-gray-800 flex items-center justify-between">
            <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white">Filter Post</h3>
            <button @click="open = false" class="p-1 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form Container --}}
        <form action="{{ route('feed.index') }}" method="GET" class="flex-1 overflow-y-auto flex flex-col justify-between">
            {{-- Hidden parameters for Alpine-managed values --}}
            <input type="hidden" name="type" :value="type">
            <input type="hidden" name="project_type" :value="projectType">
            <input type="hidden" name="skills" :value="selectedSkills.map(s => s.id).join(',')">

            {{-- Fields --}}
            <div class="px-6 py-5 space-y-6">
                {{-- 1. Post Type Segmented Control --}}
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Tipe Post</label>
                    <div class="grid grid-cols-3 bg-gray-50 dark:bg-gray-950 p-1 rounded-lg border border-border dark:border-gray-800">
                        <button type="button" @click="type = ''" 
                                :class="type === '' ? 'bg-white text-primary shadow-sm dark:bg-gray-800 font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'" 
                                class="py-2 text-xs font-medium rounded-md transition-all">
                            Semua
                        </button>
                        <button type="button" @click="type = 'discussion'" 
                                :class="type === 'discussion' ? 'bg-white text-primary shadow-sm dark:bg-gray-800 font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'" 
                                class="py-2 text-xs font-medium rounded-md transition-all">
                            Diskusi
                        </button>
                        <button type="button" @click="type = 'project'" 
                                :class="type === 'project' ? 'bg-white text-primary shadow-sm dark:bg-gray-800 font-semibold' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'" 
                                class="py-2 text-xs font-medium rounded-md transition-all">
                            Project
                        </button>
                    </div>
                </div>

                {{-- 2. Campus Area Dropdown --}}
                <div class="space-y-2">
                    <label for="filter_campus_area" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Area Kampus</label>
                    <select id="filter_campus_area" name="campus_area" x-model="campusArea" 
                            class="w-full h-11 border border-border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-950 dark:text-white rounded-input px-3 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="">Semua Area Kampus</option>
                        @foreach($campusAreas as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Category / Project Type Chip Grid --}}
                <div class="space-y-2" x-show="type === '' || type === 'project'">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori Project</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="projectType = (projectType === 'paid' ? '' : 'paid')" 
                                :class="projectType === 'paid' ? 'bg-primary-light text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-100'" 
                                class="px-3.5 py-1.5 rounded-pill text-xs font-medium border border-transparent transition-colors">
                            Paid (Berbayar)
                        </button>
                        <button type="button" @click="projectType = (projectType === 'unpaid' ? '' : 'unpaid')" 
                                :class="projectType === 'unpaid' ? 'bg-primary-light text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-100'" 
                                class="px-3.5 py-1.5 rounded-pill text-xs font-medium border border-transparent transition-colors">
                            Unpaid (Sukarela)
                        </button>
                        <button type="button" @click="projectType = (projectType === 'portfolio' ? '' : 'portfolio')" 
                                :class="projectType === 'portfolio' ? 'bg-primary-light text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-100'" 
                                class="px-3.5 py-1.5 rounded-pill text-xs font-medium border border-transparent transition-colors">
                            Portfolio
                        </button>
                    </div>
                </div>

                {{-- 4. Skills Autocomplete & Tags --}}
                <div class="space-y-2 relative">
                    <label for="filter_skills_search" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Keahlian (Skills)</label>
                    <div class="relative">
                        <input id="filter_skills_search" type="text" x-model="searchQuery" @focus="showSkillsDropdown = true" 
                               placeholder="Cari keahlian (misal: Laravel, Figma...)" 
                               class="w-full h-11 border border-border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-950 dark:text-white rounded-input px-3 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        
                        <div x-show="showSkillsDropdown && filteredSkills.length > 0" 
                             @click.outside="showSkillsDropdown = false" 
                             class="absolute left-0 right-0 mt-1 max-h-48 overflow-y-auto bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-md shadow-lg z-20 text-sm">
                            <template x-for="skill in filteredSkills" :key="skill.id">
                                <button type="button" @click="addSkill(skill)" 
                                        class="w-full text-left px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium transition-colors">
                                    <span x-text="skill.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    
                    {{-- Selected Skill Badges --}}
                    <div class="flex flex-wrap gap-1.5 mt-2 min-h-[24px]">
                        <template x-for="skill in selectedSkills" :key="skill.id">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-pill text-xs font-medium bg-primary-light text-primary border border-primary/20 dark:bg-primary/10 dark:border-primary/30">
                                <span x-text="skill.name"></span>
                                <button type="button" @click="removeSkill(skill.id)" class="text-current opacity-60 hover:opacity-100 transition-opacity ml-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        </template>
                    </div>
                </div>

                {{-- 5. Sorting Options --}}
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Urutkan</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 border border-border dark:border-gray-850 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <input type="radio" name="sort" value="latest" x-model="sortBy" class="text-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Terbaru</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-border dark:border-gray-850 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <input type="radio" name="sort" value="popular" x-model="sortBy" class="text-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Populer</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Footer Action Buttons --}}
            <div class="sticky bottom-0 bg-gray-50 dark:bg-gray-950 px-6 py-4 flex gap-3 border-t border-border dark:border-gray-800 rounded-b-2xl">
                <button type="button" @click="resetFilters" 
                        class="flex-1 h-12 border border-border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-input hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    Reset
                </button>
                <button type="submit" 
                        class="flex-1 h-12 bg-primary text-white text-sm font-semibold rounded-input hover:bg-primary-dark transition-colors shadow-sm">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function filterSheet() {
    return {
        open: false,
        type: '{{ request('type', '') }}',
        campusArea: '{{ request('campus_area', '') }}',
        projectType: '{{ request('project_type', '') }}',
        sortBy: '{{ request('sort', 'latest') }}',
        searchQuery: '',
        showSkillsDropdown: false,
        selectedSkills: @json($selectedSkills),
        allSkills: @json($allSkills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->toArray()),
        
        get filteredSkills() {
            if (!this.searchQuery) return [];
            return this.allSkills.filter(s => 
                s.name.toLowerCase().includes(this.searchQuery.toLowerCase()) && 
                !this.selectedSkills.some(selected => selected.id === s.id)
            );
        },
        addSkill(skill) {
            this.selectedSkills.push(skill);
            this.searchQuery = '';
            this.showSkillsDropdown = false;
        },
        removeSkill(id) {
            this.selectedSkills = this.selectedSkills.filter(s => s.id !== id);
        },
        resetFilters() {
            this.type = '';
            this.campusArea = '';
            this.projectType = '';
            this.sortBy = 'latest';
            this.selectedSkills = [];
            this.searchQuery = '';
        }
    };
}
</script>
@endpush
