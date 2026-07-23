@extends('layouts.app')
@section('title', 'Post Baru')

@section('content')
<div x-data="createPost()" class="max-w-2xl mx-auto px-4 py-4">

    {{-- Top Bar --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('feed.index') }}" class="p-2 -ml-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </a>
        <h1 class="text-lg font-bold font-heading text-gray-900 dark:text-white">Post Baru</h1>
        <button type="submit" form="create-post-form"
                :disabled="!isValid"
                :title="isValid ? 'Klik untuk memposting' : 'Harap lengkapi kolom yang belum terisi'"
                :class="isValid ? 'bg-primary text-white hover:bg-primary-dark active:scale-[0.98]' : 'bg-gray-200 text-gray-400 dark:bg-slate-800 dark:text-slate-650 cursor-not-allowed'"
                class="px-5 py-2 text-sm font-bold rounded-pill transition-all duration-150 select-none">
            Posting
        </button>
    </div>

    {{-- Segmented Toggle: Diskusi | Project --}}
    <div class="bg-slate-100 dark:bg-slate-800 p-1 rounded-md border border-gray-200 dark:border-slate-700 mb-6">
        <div class="grid grid-cols-2">
            <button type="button" @click="type = 'discussion'"
                    :class="type === 'discussion' ? 'bg-white dark:bg-slate-900 text-primary shadow-sm font-bold' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200'"
                    class="py-2.5 text-sm font-semibold rounded-md transition-all">
                <span class="flex items-center justify-center gap-1.5">
                    <x-ui.icon name="comment" class="w-4.5 h-4.5" stroke-width="2" />
                    Diskusi
                </span>
            </button>
            <button type="button" @click="type = 'project'"
                    :class="type === 'project' ? 'bg-white dark:bg-slate-900 text-primary shadow-sm font-bold' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200'"
                    class="py-2.5 text-sm font-semibold rounded-md transition-all">
                <span class="flex items-center justify-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                    </svg>
                    Project
                </span>
            </button>
        </div>
    </div>

    {{-- Form --}}
    <form id="create-post-form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <input type="hidden" name="type" :value="type">

        {{-- Error Summary --}}
        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/40 rounded-card p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-red-700 dark:text-red-400">Terjadi kesalahan</span>
                </div>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs text-red-600 dark:text-red-400">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dynamic Client-side Live Validation Feedback --}}
        <div x-show="!isValid" x-transition.opacity class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/40 rounded-card p-3.5 text-xs text-amber-800 dark:text-amber-300 space-y-1.5">
            <div class="flex items-center gap-1.5 font-bold text-amber-900 dark:text-amber-200">
                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <span>Petunjuk Pengisian (Lengkapi agar tombol Posting aktif):</span>
            </div>
            <ul class="list-disc list-inside space-y-1 pl-1">
                <template x-for="(msg, index) in validationMessages" :key="index">
                    <li x-text="msg"></li>
                </template>
            </ul>
        </div>

        {{-- === Discussion Fields === --}}
        <div x-show="type === 'discussion'" x-transition.opacity class="space-y-5">
            {{-- Title (optional for discussion) --}}
            <div class="space-y-1.5">
                <label for="disc_title" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Judul <span class="text-gray-400 dark:text-slate-500 font-normal normal-case">(opsional)</span></label>
                <input id="disc_title" type="text" x-model="title"
                       name="title" maxlength="150"
                       placeholder="Berikan judul yang menarik..."
                       class="w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>

            {{-- Body --}}
            <div class="space-y-1.5">
                <label for="disc_body" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Konten <span class="text-red-500">*</span></label>
                <textarea id="disc_body" x-model="body"
                          name="body" rows="6"
                          placeholder="Apa yang ingin kamu diskusikan? Ceritakan ide, pertanyaan, atau pengalaman..."
                          class="w-full rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none leading-relaxed"></textarea>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span x-show="body.trim().length < 10" class="text-amber-600 dark:text-amber-400 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        <span x-text="body.trim().length === 0 ? 'Wajib diisi minimal 10 karakter' : 'Kurang ' + (10 - body.trim().length) + ' karakter lagi'"></span>
                    </span>
                    <span x-show="body.trim().length >= 10" class="text-emerald-500 flex items-center gap-1 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                        Sesuai (min. 10 karakter)
                    </span>
                    <span class="ml-auto text-gray-400 dark:text-slate-500" x-text="body.length + ' karakter'"></span>
                </div>
            </div>
        </div>

        {{-- === Project Fields === --}}
        <div x-show="type === 'project'" x-transition.opacity class="space-y-5">
            {{-- Title (required) --}}
            <div class="space-y-1.5">
                <label for="proj_title" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Judul Project <span class="text-red-500">*</span></label>
                <input id="proj_title" type="text" x-model="title"
                       name="title" maxlength="150"
                       placeholder="Contoh: Dicari partner frontend React untuk app marketplace"
                       class="w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                <div class="flex items-center justify-between text-xs pt-0.5">
                    <span x-show="title.trim().length === 0" class="text-amber-600 dark:text-amber-400 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        Judul project wajib diisi
                    </span>
                    <span x-show="title.trim().length > 0" class="text-emerald-500 flex items-center gap-1 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                        Judul terisi
                    </span>
                </div>
                @error('title')
                    <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="space-y-1.5">
                <label for="proj_body" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Deskripsi <span class="text-red-500">*</span></label>
                <textarea id="proj_body" x-model="body"
                          name="body" rows="5"
                          placeholder="Jelaskan project kamu: apa yang sedang dibangun, siapa yang dibutuhkan, dan apa tanggung jawabnya..."
                          class="w-full rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none leading-relaxed"></textarea>
                <div class="flex items-center justify-between text-xs pt-0.5">
                    <span x-show="body.trim().length < 10" class="text-amber-600 dark:text-amber-400 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        <span x-text="body.trim().length === 0 ? 'Wajib diisi minimal 10 karakter' : 'Kurang ' + (10 - body.trim().length) + ' karakter lagi'"></span>
                    </span>
                    <span x-show="body.trim().length >= 10" class="text-emerald-500 flex items-center gap-1 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                        Sesuai (min. 10 karakter)
                    </span>
                    <span class="ml-auto text-gray-400 dark:text-slate-500" x-text="body.length + ' karakter'"></span>
                </div>
            </div>

            {{-- Skill Multi-Select --}}
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Keahlian yang Dibutuhkan</label>
                <div class="relative" @click.outside="skillDropdown = false">
                    <input type="text" x-model="skillSearch" @focus="skillDropdown = true" @input="skillDropdown = true"
                           placeholder="Cari skill (misal: Laravel, React, Figma...)"
                           class="w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">

                    {{-- Dropdown --}}
                    <div x-show="skillDropdown && filteredSkills.length > 0"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 right-0 mt-1 max-h-44 overflow-y-auto bg-white dark:bg-gray-800 border border-border dark:border-gray-700 rounded-lg shadow-lg z-20"
                         style="display: none;">
                        <template x-for="skill in filteredSkills" :key="skill.id">
                            <button type="button" @click="addSkill(skill)"
                                    class="w-full text-left px-4 py-2.5 hover:bg-primary-light dark:hover:bg-primary/10 text-sm text-gray-700 dark:text-gray-300 transition-colors flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <span x-text="skill.name"></span>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Selected Skill Chips --}}
                <div class="flex flex-wrap gap-1.5 mt-2 min-h-[28px]">
                    <template x-for="skill in selectedSkills" :key="skill.id">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-pill text-xs font-medium bg-primary-light text-primary border border-primary/20 dark:bg-primary/10 dark:border-primary/30 animate-in">
                            <span x-text="skill.name"></span>
                            <button type="button" @click="removeSkill(skill.id)" class="text-current opacity-60 hover:opacity-100 transition-opacity">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" name="skills[]" :value="skill.id">
                        </span>
                    </template>
                </div>
            </div>

            {{-- Project Type --}}
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tipe Kolaborasi</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" @click="projectType = (projectType === 'paid' ? '' : 'paid')"
                            :class="projectType === 'paid' ? 'border-primary bg-primary-light text-primary dark:bg-primary/10 font-bold' : 'border-gray-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800'"
                            class="p-3 border rounded-lg text-xs text-center transition-all flex flex-col items-center gap-1.5 select-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                        </svg>
                        Paid
                    </button>
                    <button type="button" @click="projectType = (projectType === 'unpaid' ? '' : 'unpaid')"
                            :class="projectType === 'unpaid' ? 'border-primary bg-primary-light text-primary dark:bg-primary/10 font-bold' : 'border-gray-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800'"
                            class="p-3 border rounded-lg text-xs text-center transition-all flex flex-col items-center gap-1.5 select-none cursor-pointer">
                        <x-ui.icon name="like" class="w-5 h-5" stroke-width="1.5" />
                        Sukarela
                    </button>
                    <button type="button" @click="projectType = (projectType === 'portfolio' ? '' : 'portfolio')"
                            :class="projectType === 'portfolio' ? 'border-primary bg-primary-light text-primary dark:bg-primary/10 font-bold' : 'border-gray-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800'"
                            class="p-3 border rounded-lg text-xs text-center transition-all flex flex-col items-center gap-1.5 select-none cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        Portfolio
                    </button>
                </div>
                <input type="hidden" name="project_type" :value="projectType">
            </div>

            {{-- Deadline --}}
            <div class="space-y-1.5">
                <label for="proj_deadline" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Deadline</label>
                <input id="proj_deadline" type="date" name="deadline"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm text-gray-900 dark:text-slate-100 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>

            {{-- Campus Area --}}
            <div class="space-y-1.5">
                <label for="proj_campus" class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Area Kampus</label>
                <select id="proj_campus" name="campus_area"
                        class="w-full h-11 rounded-input border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm text-gray-900 dark:text-slate-100 transition-all duration-150 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="">Semua area kampus</option>
                    @foreach($campusAreas as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- === Shared: Image Upload === --}}
        <div class="space-y-1.5">
            <label class="block text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Gambar <span class="text-gray-400 dark:text-slate-500 font-normal normal-case">(opsional, max 5MB)</span></label>
            <div class="relative">
                <label for="image_upload"
                       @dragover.prevent="dragOver = true"
                       @dragleave.prevent="dragOver = false"
                       @drop.prevent="
                           dragOver = false;
                           const file = $event.dataTransfer.files[0];
                           if (file && file.type.startsWith('image/')) {
                               document.getElementById('image_upload').files = $event.dataTransfer.files;
                               previewImageFromFile(file);
                           }
                       "
                       :class="dragOver ? 'border-primary bg-primary-light/20' : 'border-gray-300 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/60'"
                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-card cursor-pointer hover:border-primary hover:bg-primary-light/10 transition-all"
                       x-show="!imagePreview">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                    </svg>
                    <span class="text-xs text-gray-500 dark:text-gray-400" x-show="!dragOver">Klik atau drag & drop gambar di sini</span>
                    <span class="text-xs text-primary font-medium" x-show="dragOver" x-cloak>Lepaskan gambar di sini</span>
                </label>

                {{-- Image Preview --}}
                <div x-show="imagePreview" class="relative rounded-card overflow-hidden border border-border dark:border-gray-800" style="display: none;">
                    <img :src="imagePreview" alt="Preview" class="w-full h-40 object-cover">
                    <button type="button" @click="removeImage"
                            class="absolute top-2 right-2 w-8 h-8 bg-black/60 text-white rounded-full flex items-center justify-center hover:bg-black/80 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <input id="image_upload" type="file" name="image" accept="image/*" class="hidden"
                       @change="previewImage($event)">
            </div>
        </div>

        {{-- Form Actions Footer --}}
        <div class="pt-6 border-t border-gray-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end items-center gap-3">
            <x-ui.button variant="outlined" size="md" :href="route('feed.index')" class="w-full sm:w-auto">
                Batal
            </x-ui.button>
            <x-ui.button variant="primary" size="md" type="submit" x-bind:disabled="!isValid" :title="isValid ? 'Klik untuk memposting' : 'Harap lengkapi kolom yang belum terisi'" class="w-full sm:w-auto">
                Posting Sekarang
            </x-ui.button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function createPost() {
    return {
        type: '{{ old('type', 'discussion') }}',
        title: '{{ old('title', '') }}',
        body: `{{ old('body', '') }}`,
        projectType: '{{ old('project_type', '') }}',
        skillSearch: '',
        skillDropdown: false,
        selectedSkills: [],
        allSkills: @json($skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])),
        imagePreview: null,
        dragOver: false,

        get filteredSkills() {
            if (!this.skillSearch) return [];
            return this.allSkills.filter(s =>
                s.name.toLowerCase().includes(this.skillSearch.toLowerCase()) &&
                !this.selectedSkills.some(sel => sel.id === s.id)
            );
        },

        get isValid() {
            if (this.type === 'discussion') {
                return this.body.trim().length >= 10;
            }
            // project
            return this.title.trim().length > 0 && this.body.trim().length >= 10;
        },

        get validationMessages() {
            let msgs = [];
            if (this.type === 'project' && this.title.trim().length === 0) {
                msgs.push('Judul project wajib diisi.');
            }
            if (this.body.trim().length < 10) {
                const remaining = 10 - this.body.trim().length;
                if (this.body.trim().length === 0) {
                    msgs.push(this.type === 'project' ? 'Deskripsi project wajib diisi minimal 10 karakter.' : 'Konten diskusi wajib diisi minimal 10 karakter.');
                } else {
                    msgs.push(`Konten/deskripsi kurang ${remaining} karakter lagi (min. 10 karakter).`);
                }
            }
            return msgs;
        },

        addSkill(skill) {
            this.selectedSkills.push(skill);
            this.skillSearch = '';
            this.skillDropdown = false;
        },

        removeSkill(id) {
            this.selectedSkills = this.selectedSkills.filter(s => s.id !== id);
        },

        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        previewImageFromFile(file) {
            if (file && file.type.startsWith('image/')) {
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        removeImage() {
            this.imagePreview = null;
            document.getElementById('image_upload').value = '';
        }
    };
}
</script>
@endpush
@endsection
