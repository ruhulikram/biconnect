@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto px-4 md:px-6 py-4">

    {{-- ═══════ Top Bar ═══════ --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('profile.show') }}"
           class="p-1.5 rounded-input hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <h1 class="text-lg font-bold font-heading text-gray-900 dark:text-white">Edit Profil</h1>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" x-data="editProfileForm()">
        @csrf
        @method('PUT')

        {{-- ═══════ Cover & Avatar Upload Container ═══════ --}}
        <div class="relative mb-16">
            {{-- Cover Upload --}}
            <div class="relative rounded-card overflow-hidden bg-gray-100 dark:bg-slate-800 h-[120px] md:h-[150px] group cursor-pointer"
                 @click="$refs.coverInput.click()">
                <img :src="coverPreview || '{{ $user->cover_url }}'"
                     alt="Cover"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <div class="text-white text-center">
                        <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                        </svg>
                        <span class="text-xs font-medium">Ubah Sampul</span>
                    </div>
                </div>
                <input type="file" name="cover" x-ref="coverInput" class="hidden" accept="image/*"
                       @change="previewCover($event)">
            </div>

            {{-- Avatar Upload (overlapping cover) --}}
            <div class="absolute -bottom-[36px] left-4 md:left-6 z-10"
                 @click.stop="$refs.avatarInput.click()">
                <div class="relative w-[72px] h-[72px] md:w-[84px] md:h-[84px] rounded-full border-4 border-white dark:border-slate-900 overflow-hidden bg-primary-light shadow-sm group/avatar cursor-pointer">
                    <img :src="avatarPreview || '{{ $user->avatar_url }}'"
                         alt="{{ $user->name }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover/avatar:opacity-100 transition-opacity flex items-center justify-center rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                        </svg>
                    </div>
                </div>
                <input type="file" name="avatar" x-ref="avatarInput" class="hidden" accept="image/*"
                       @change="previewAvatar($event)">
            </div>
        </div>

        {{-- Upload error messages --}}
        @error('avatar')
            <p class="text-xs text-red-500 mb-2">{{ $message }}</p>
        @enderror
        @error('cover')
            <p class="text-xs text-red-500 mb-2">{{ $message }}</p>
        @enderror

        {{-- ═══════ Form Fields ═══════ --}}
        <div class="space-y-4">

            {{-- Nama Lengkap --}}
            <x-ui.input
                name="name"
                label="Nama Lengkap"
                placeholder="Masukkan nama lengkap"
                :value="old('name', $user->name)"
                :error="$errors->first('name')"
                required />

            {{-- Bio --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Bio</label>
                <textarea
                    name="bio"
                    rows="3"
                    maxlength="500"
                    x-model="bio"
                    placeholder="Ceritakan sedikit tentang dirimu..."
                    class="w-full rounded-input border border-border bg-white dark:bg-slate-900 dark:border-slate-700 px-4 py-3 text-sm placeholder-gray-400 text-gray-900 dark:text-gray-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus resize-none {{ $errors->has('bio') ? 'border-red-500' : '' }}">{{ old('bio', $user->bio) }}</textarea>
                <div class="flex items-center justify-between">
                    @error('bio')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @else
                        <span></span>
                    @enderror
                    <p class="text-xs text-gray-400" x-text="bio.length + '/500'"></p>
                </div>
            </div>

            {{-- WhatsApp --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Nomor WhatsApp
                    <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                    </span>
                    <input type="tel"
                           name="whatsapp"
                           value="{{ old('whatsapp', $user->whatsapp) }}"
                           placeholder="628xxxxxxxxxx"
                           class="w-full h-12 rounded-input border border-border dark:border-slate-700 bg-white dark:bg-slate-900 pl-10 pr-4 text-sm placeholder-gray-400 text-gray-900 dark:text-gray-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus
                                  {{ $errors->has('whatsapp') ? 'border-red-500' : '' }}">
                </div>
                @error('whatsapp')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @else
                    <p class="text-xs text-gray-400">Digunakan untuk memudahkan koneksi antar kolaborator. Format: 628xxxxxxxxxx</p>
                @enderror
            </div>

            {{-- Program Studi --}}
            <x-ui.input
                name="program"
                label="Program Studi"
                placeholder="Contoh: Sistem Informasi"
                :value="old('program', $user->program)"
                :error="$errors->first('program')" />


            {{-- Row: Semester + Kampus --}}
            <div class="grid grid-cols-2 gap-3">
                <x-ui.input
                    name="semester"
                    type="number"
                    label="Semester"
                    placeholder="1"
                    min="1"
                    max="14"
                    :value="old('semester', $user->semester)"
                    :error="$errors->first('semester')" />

                <div class="space-y-1.5">
                    <label for="campus_area" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Kampus Area</label>
                    <div class="relative">
                        <select id="campus_area" name="campus_area"
                                class="w-full h-12 rounded-input border border-border dark:border-gray-700 bg-white dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-slate-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus appearance-none
                                       {{ $errors->has('campus_area') ? 'border-red-500' : '' }}">
                            <option value="">Pilih Kampus Area</option>
                            @foreach($campusAreas as $region => $campuses)
                                <optgroup label="{{ $region }}" class="bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100">
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->code }}" {{ old('campus_area', $user->campus_area) == $campus->code ? 'selected' : '' }}>
                                            {{ $campus->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @if($errors->has('campus_area'))
                        <p class="text-xs text-red-500 mt-1">{{ $errors->first('campus_area') }}</p>
                    @endif
                </div>
            </div>

            {{-- ═══════ Skills Selector ═══════ --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Keahlian</label>

                {{-- Search Input --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text"
                           x-model="skillSearch"
                           @focus="showSkillsDropdown = true"
                           @click.outside="showSkillsDropdown = false"
                           placeholder="Cari keahlian..."
                           class="w-full h-10 rounded-input border border-border dark:border-slate-700 bg-white dark:bg-slate-900 pl-10 pr-4 text-sm placeholder-gray-400 text-gray-900 dark:text-gray-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus">
                </div>

                {{-- Dropdown --}}
                <div x-show="showSkillsDropdown && filteredSkills().length > 0"
                     x-transition
                     class="border border-gray-200 dark:border-slate-700 rounded-input bg-white dark:bg-slate-800 shadow-md max-h-40 overflow-y-auto"
                     style="display: none;">
                    <template x-for="skill in filteredSkills()" :key="skill.id">
                        <button type="button"
                                @click="toggleSkill(skill.id)"
                                class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-slate-700 flex items-center justify-between transition-colors"
                                :class="selectedSkills.includes(skill.id) ? 'text-primary font-medium bg-primary-light/50 dark:bg-primary/10' : 'text-gray-700 dark:text-gray-300'">
                            <span x-text="skill.name"></span>
                            <svg x-show="selectedSkills.includes(skill.id)" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </template>
                </div>

                {{-- Selected Skills Chips --}}
                <div class="flex flex-wrap gap-1.5 mt-2" x-show="selectedSkills.length > 0">
                    <template x-for="skillId in selectedSkills" :key="skillId">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-pill text-xs font-medium bg-primary-light text-primary border border-primary/20 cursor-pointer transition-colors">
                            <span x-text="getSkillName(skillId)"></span>
                            <button type="button" @click="toggleSkill(skillId)" class="text-current opacity-60 hover:opacity-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" name="skills[]" :value="skillId">
                        </span>
                    </template>
                </div>

                @error('skills')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ═══════ Social Media Links ═══════ --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Media Sosial <span class="text-gray-400 font-normal">(opsional)</span></label>
                <p class="text-xs text-gray-400 mb-3">Tambahkan tautan ke profil media sosial kamu.</p>

                @php
                    $socialFields = [
                        'linkedin'  => ['icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z', 'placeholder' => 'https://linkedin.com/in/username'],
                        'github'    => ['icon' => 'M15 22v-4a4.8 4.8 0 00-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 004 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4M15 18c-6 2-7-4-7-4', 'placeholder' => 'https://github.com/username'],
                        'instagram' => ['icon' => 'M16 3H8a5 5 0 00-5 5v8a5 5 0 005 5h8a5 5 0 005-5V8a5 5 0 00-5-5zm-4 14a5 5 0 110-10 5 5 0 010 10zm5.5-11.5a1 1 0 110-2 1 1 0 010 2z', 'placeholder' => 'https://instagram.com/username'],
                        'twitter'   => ['icon' => 'M4 4l11.733 16h4.267l-11.733-16zM4 20l6.768-6.768M20 4l-6.768 6.768', 'placeholder' => 'https://x.com/username'],
                        'website'   => ['icon' => 'M12 2a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16zm0-14a6 6 0 010 12V6z', 'placeholder' => 'https://example.com'],
                    ];
                @endphp

                <div class="space-y-2.5">
                    @foreach($socialFields as $platform => $field)
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="{{ $field['icon'] }}"/>
                                </svg>
                            </span>
                            <input type="url" name="social_{{ $platform }}"
                                   value="{{ old("social_{$platform}", $socialLinks[$platform] ?? '') }}"
                                   placeholder="{{ $field['placeholder'] }}"
                                   class="w-full h-10 rounded-input border border-border dark:border-slate-700 bg-white dark:bg-slate-900 pl-10 pr-4 text-sm placeholder-gray-400 text-gray-900 dark:text-gray-100 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ═══════ Action Buttons (Bottom) ═══════ --}}
        <div class="flex items-center gap-3 mt-8 pb-6">
            <x-ui.button variant="outlined" :href="route('profile.show')" class="flex-1">
                Batal
            </x-ui.button>
            <x-ui.button variant="primary" type="submit" class="flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Simpan
            </x-ui.button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function editProfileForm() {
    return {
        bio: @json(old('bio', $user->bio ?? '')),
        avatarPreview: null,
        coverPreview: null,
        skillSearch: '',
        showSkillsDropdown: false,
        selectedSkills: @json($selectedSkillIds),
        allSkills: @json($allSkills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])),

        previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        },

        previewCover(event) {
            const file = event.target.files[0];
            if (file) {
                this.coverPreview = URL.createObjectURL(file);
            }
        },

        filteredSkills() {
            const q = this.skillSearch.toLowerCase().trim();
            if (!q) return this.allSkills;
            return this.allSkills.filter(s => s.name.toLowerCase().includes(q));
        },

        toggleSkill(id) {
            const idx = this.selectedSkills.indexOf(id);
            if (idx === -1) {
                this.selectedSkills.push(id);
            } else {
                this.selectedSkills.splice(idx, 1);
            }
        },

        getSkillName(id) {
            const skill = this.allSkills.find(s => s.id === id);
            return skill ? skill.name : '';
        }
    };
}
</script>
@endpush
