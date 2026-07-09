@extends('layouts.auth')
@section('title', 'Pilih Keahlian')

@section('content')
<div class="space-y-6" x-data="skillsForm()">

    {{-- Progress --}}
    <div class="space-y-2">
        <div class="flex justify-between items-center text-xs font-medium text-gray-500">
            <span>Langkah 2 dari 2</span>
            <span>Keahlian</span>
        </div>
        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 100%"></div>
        </div>
    </div>

    {{-- Logo & Heading --}}
    <div class="text-center pt-2">
        <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" class="h-10 w-auto mx-auto mb-4">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Apa keahlian kamu?</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Pilih minimal 3 keahlian untuk menyesuaikan feed dan project yang relevan denganmu.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('onboarding.save-skills') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Search & Counter --}}
        <div class="space-y-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text"
                       x-model="search"
                       placeholder="Cari keahlian..."
                       class="w-full h-11 rounded-input border border-border bg-white pl-10 pr-4 text-sm placeholder-gray-400 text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus">
            </div>

            <div class="flex items-center justify-between">
                <span class="text-xs font-medium" 
                      :class="selectedSkills.length >= 3 ? 'text-green-600' : 'text-gray-500'">
                    <span x-text="selectedSkills.length"></span>/3 keahlian dipilih
                </span>
                <span x-show="selectedSkills.length < 3" class="text-xs text-red-500">Pilih <span x-text="3 - selectedSkills.length"></span> lagi</span>
            </div>
        </div>

        {{-- Skills Grid --}}
        <div class="flex flex-wrap gap-2 max-h-60 overflow-y-auto pr-2 no-scrollbar">
            <template x-for="skill in filteredSkills()" :key="skill.id">
                <label class="cursor-pointer">
                    <input type="checkbox" name="skills[]" :value="skill.id" x-model="selectedSkills" class="hidden">
                    <div class="px-4 py-2 rounded-pill text-sm font-medium transition-colors border select-none"
                         :class="selectedSkills.includes(skill.id) 
                                ? 'bg-primary-light text-primary border-primary/20' 
                                : 'bg-white text-gray-600 border-border hover:border-primary/50'">
                        <span x-text="skill.name"></span>
                    </div>
                </label>
            </template>
            
            {{-- Empty state for search --}}
            <div x-show="filteredSkills().length === 0" class="w-full text-center py-4 text-sm text-gray-500">
                Keahlian tidak ditemukan.
            </div>
        </div>
        
        @if($errors->has('skills'))
            <p class="text-xs text-red-500">{{ $errors->first('skills') }}</p>
        @endif

        {{-- Actions --}}
        <div class="pt-4 flex items-center gap-3 border-t border-gray-100">
            <button type="submit" formaction="{{ route('onboarding.skip') }}" formnovalidate
                    class="w-1/3 h-12 rounded-input border border-border text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors">
                Lewati
            </button>
            
            <button type="submit"
                    :disabled="selectedSkills.length < 3"
                    class="w-2/3 h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                           hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20 flex justify-center items-center gap-2
                           disabled:opacity-50 disabled:cursor-not-allowed">
                Selesai
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function skillsForm() {
    return {
        search: '',
        allSkills: @json($allSkills->map(fn($s) => ['id' => (string)$s->id, 'name' => $s->name])),
        selectedSkills: @json(array_map('strval', old('skills', $selectedSkills))),
        
        filteredSkills() {
            if (this.search === '') {
                return this.allSkills;
            }
            return this.allSkills.filter(skill => 
                skill.name.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }
}
</script>
@endpush
