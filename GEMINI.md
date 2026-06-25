# GEMINI.md — BiConnect UI/UX Implementation Guide
> Laravel Blade + Vite · Tailwind CSS v3 · Web-first
> Version 1.0 · Panduan untuk AI Agent & Developer

---

## 1. Stack & Environment

```
Backend  : Laravel 11+
Templating: Laravel Blade (.blade.php)
Build Tool: Vite (via laravel-vite-plugin)
CSS      : Tailwind CSS v3
Icons    : Lucide (via lucide-react atau CDN SVG)
Fonts    : Plus Jakarta Sans + Inter (Google Fonts)
```

### Setup Vite + Tailwind (Referensi)
```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

```css
/* resources/css/app.css */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap');

@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  :root {
    --color-primary: #1E40AF;
    --color-primary-light: #EFF6FF;
    --color-primary-dark: #1D4ED8;
    --color-accent: #D97706;
    --color-accent-light: #FEF3C7;
  }

  html { font-family: 'Inter', sans-serif; }
  h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
}
```

```js
// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#1E40AF',
          light: '#EFF6FF',
          dark: '#1D4ED8',
        },
        accent: {
          DEFAULT: '#D97706',
          light: '#FEF3C7',
        },
        surface: '#F8FAFC',
        border: '#E2E8F0',
      },
      borderRadius: {
        'card': '12px',
        'input': '6px',
        'pill': '999px',
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03)',
        'fab': '0 4px 12px rgba(217,119,6,0.3)',
        'focus': '0 0 0 3px rgba(30,64,175,0.15)',
      },
    },
  },
  plugins: [],
}
```

---

## 2. Blade Layout Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php          ← Layout utama (navbar + footer)
│   │   ├── auth.blade.php         ← Layout halaman auth (centered card)
│   │   └── admin.blade.php        ← Layout admin (sidebar + main)
│   ├── components/
│   │   ├── navbar.blade.php
│   │   ├── footer.blade.php
│   │   ├── bottom-nav.blade.php
│   │   ├── card/
│   │   │   ├── discussion.blade.php
│   │   │   └── project.blade.php
│   │   ├── ui/
│   │   │   ├── button.blade.php
│   │   │   ├── input.blade.php
│   │   │   ├── chip.blade.php
│   │   │   ├── badge.blade.php
│   │   │   ├── avatar.blade.php
│   │   │   └── otp-input.blade.php
│   │   └── modals/
│   │       ├── filter-sheet.blade.php
│   │       └── report.blade.php
│   ├── auth/
│   │   ├── activate.blade.php
│   │   ├── otp.blade.php
│   │   ├── create-password.blade.php
│   │   └── login.blade.php
│   ├── onboarding/
│   │   └── skills.blade.php
│   ├── feed/
│   │   ├── index.blade.php
│   │   └── create.blade.php
│   ├── post/
│   │   └── show.blade.php
│   ├── profile/
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   ├── notifications/
│   │   └── index.blade.php
│   ├── settings/
│   │   └── index.blade.php
│   ├── admin/
│   │   └── dashboard.blade.php
│   └── landing.blade.php
```

---

## 3. Layout Utama (`layouts/app.blade.php`)

```blade
<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BiConnect') — Platform Kolaborasi Mahasiswa BSI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-body text-gray-900 antialiased">

    {{-- Sticky Top Navbar --}}
    @include('components.navbar')

    {{-- Main Content --}}
    <main class="min-h-screen pb-20 md:pb-0">
        @yield('content')
    </main>

    {{-- Footer (Desktop only) --}}
    <div class="hidden md:block">
        @include('components.footer')
    </div>

    {{-- Bottom Nav (Mobile only) --}}
    <div class="block md:hidden">
        @include('components.bottom-nav')
    </div>

    {{-- Toast Notifications --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-24 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm px-4 py-2.5 rounded-pill shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @stack('scripts')
</body>
</html>
```

---

## 4. Komponen Footer (`components/footer.blade.php`)

Footer mengikuti referensi desain dark footer dengan 4 kolom: Brand · Pages · Information · Contact.

```blade
<footer class="bg-[#1a1a1a] text-gray-400 pt-12 pb-6">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">

        {{-- 4-column grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-10 border-b border-white/10">

            {{-- Col 1: Brand --}}
            <div class="space-y-4">
                <img src="{{ asset('images/biconnect-logo.png') }}"
                     alt="BiConnect Logo"
                     class="h-9 w-auto brightness-0 invert">
                <address class="not-italic text-sm text-gray-500 leading-relaxed">
                    Jl. Kramat Raya No.98, RT.2/RW.9, Kwitang,<br>
                    Kec. Senen, Kota Jakarta Pusat,<br>
                    DKI Jakarta 10450
                </address>
            </div>

            {{-- Col 2: Pages --}}
            <div>
                <h4 class="text-white text-sm font-semibold font-heading mb-4">Pages</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('feed.index') }}"      class="hover:text-white transition-colors">Feed</a></li>
                    <li><a href="{{ route('profile.show') }}"    class="hover:text-white transition-colors">Profil</a></li>
                    <li><a href="{{ route('feed.index') }}?type=project" class="hover:text-white transition-colors">Projects</a></li>
                    <li><a href="{{ route('notifications.index') }}" class="hover:text-white transition-colors">Notifikasi</a></li>
                    <li><a href="#"                              class="hover:text-white transition-colors">Portfolio</a></li>
                </ul>
            </div>

            {{-- Col 3: Information --}}
            <div>
                <h4 class="text-white text-sm font-semibold font-heading mb-4">Information</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Tim Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Tentang BiConnect</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{ route('settings.index') }}"  class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Col 4: Contact --}}
            <div>
                <h4 class="text-white text-sm font-semibold font-heading mb-4">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        {{-- Home icon --}}
                        <svg class="w-4 h-4 mt-0.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        <span>Universitas Bina Sarana Informatika</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        {{-- Mail icon --}}
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        <a href="mailto:admin@biconnect.bsi.ac.id" class="hover:text-white transition-colors">
                            admin@biconnect.bsi.ac.id
                        </a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        {{-- Phone icon --}}
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        <span>(021) 28534471</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright bar --}}
        <div class="pt-6 text-center text-xs text-gray-600">
            Copyright © {{ date('Y') }}
            <a href="https://bsi.ac.id" target="_blank"
               class="text-primary hover:text-primary-dark transition-colors mx-1">
                Biro Teknologi Informasi Universitas Bina Sarana Informatika
            </a>
            · Designed with <span class="text-red-500">❤</span> All rights reserved.
        </div>

    </div>
</footer>
```

---

## 5. Komponen Navbar (`components/navbar.blade.php`)

```blade
<nav class="sticky top-0 z-40 bg-white border-b border-border h-14 flex items-center">
    <div class="w-full max-w-6xl mx-auto px-4 md:px-6 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('feed.index') }}" class="flex items-center">
            <img src="{{ asset('images/biconnect-logo.png') }}"
                 alt="BiConnect" class="h-8 w-auto">
        </a>

        {{-- Desktop nav links --}}
        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('feed.index') }}"
               class="px-3 py-1.5 rounded-input text-sm font-medium
                      {{ request()->routeIs('feed.*') ? 'text-primary bg-primary-light' : 'text-gray-600 hover:bg-gray-50' }}">
                Feed
            </a>
            <a href="{{ route('feed.index') }}?type=project"
               class="px-3 py-1.5 rounded-input text-sm font-medium text-gray-600 hover:bg-gray-50">
                Project
            </a>
        </div>

        {{-- Right actions --}}
        <div class="flex items-center gap-2">
            {{-- Search --}}
            <button class="p-2 rounded-input hover:bg-gray-50 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </button>

            {{-- Notifications --}}
            <a href="{{ route('notifications.index') }}"
               class="relative p-2 rounded-input hover:bg-gray-50 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
                @if(auth()->user()?->unread_notifications_count > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </a>

            {{-- Avatar --}}
            <a href="{{ route('profile.show') }}"
               class="w-8 h-8 rounded-full bg-primary-light overflow-hidden">
                <img src="{{ auth()->user()?->avatar_url ?? asset('images/avatar-placeholder.png') }}"
                     alt="Profil" class="w-full h-full object-cover">
            </a>
        </div>
    </div>
</nav>
```

---

## 6. Komponen UI Reusable

### Button (`components/ui/button.blade.php`)
```blade
@props([
    'variant' => 'primary',  // primary | outlined | text | danger
    'size'    => 'md',        // sm | md | lg
    'type'    => 'button',
    'disabled'=> false,
    'full'    => false,
])

@php
$base = 'inline-flex items-center justify-center font-medium rounded-input transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-primary/20';

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs h-8',
    'md' => 'px-5 py-3 text-sm h-12',
    'lg' => 'px-6 py-3.5 text-base h-14',
];

$variants = [
    'primary'  => 'bg-primary text-white hover:bg-primary-dark disabled:opacity-40',
    'outlined' => 'border border-primary text-primary hover:bg-primary-light disabled:opacity-40',
    'text'     => 'text-primary hover:bg-primary-light disabled:opacity-40',
    'danger'   => 'text-red-500 border border-red-200 hover:bg-red-50',
];

$classes = $base . ' ' . $sizes[$size] . ' ' . $variants[$variant] . ($full ? ' w-full' : '');
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
```

### Input (`components/ui/input.blade.php`)
```blade
@props([
    'label'       => null,
    'error'       => null,
    'helper'      => null,
    'icon'        => null,
    'iconRight'   => null,
])

<div class="space-y-1.5">
    @if($label)
        <label class="block text-xs font-medium text-gray-700">{{ $label }}</label>
    @endif

    <div class="relative">
        @if($icon)
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                {!! $icon !!}
            </span>
        @endif

        <input
            {{ $attributes->merge([
                'class' => 'w-full h-12 rounded-input border border-border bg-white px-4 py-3 text-sm
                            placeholder-gray-400 text-gray-900 transition-shadow duration-150
                            focus:outline-none focus:border-primary focus:shadow-focus
                            ' . ($icon ? 'pl-10' : '') . '
                            ' . ($error ? 'border-red-500' : '') . '
                            ' . ($iconRight ? 'pr-10' : '')
            ]) }}>

        @if($iconRight)
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                {!! $iconRight !!}
            </span>
        @endif
    </div>

    @if($error)
        <p class="text-xs text-red-500 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            {{ $error }}
        </p>
    @elseif($helper)
        <p class="text-xs text-gray-400">{{ $helper }}</p>
    @endif
</div>
```

### Chip (`components/ui/chip.blade.php`)
```blade
@props([
    'selected'   => false,
    'removable'  => false,
    'value'      => '',
])

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-pill text-xs font-medium cursor-pointer transition-colors duration-150 '
               . ($selected
                  ? 'bg-primary-light text-primary border border-primary/20'
                  : 'bg-gray-100 text-gray-600 border border-transparent hover:border-border')
]) }}>
    {{ $slot }}
    @if($removable)
        <button type="button" class="text-current opacity-60 hover:opacity-100 ml-0.5">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</span>
```

### Badge (`components/ui/badge.blade.php`)
```blade
@props(['type' => 'project'])

@php
$styles = [
    'project'   => 'bg-accent-light text-accent',
    'paid'      => 'bg-green-50 text-green-600',
    'unpaid'    => 'bg-gray-100 text-gray-500',
    'portfolio' => 'bg-primary-light text-primary',
];
@endphp

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center px-2.5 py-1 rounded-pill text-xs font-semibold ' . ($styles[$type] ?? $styles['project'])
]) }}>
    {{ $slot }}
</span>
```

---

## 7. Card Components

### Project Card (`components/card/project.blade.php`)
```blade
@props(['post'])

<article class="bg-white border border-border rounded-card p-4 shadow-card hover:shadow-md transition-shadow">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-2.5 min-w-0">
            <img src="{{ $post->user->avatar_url }}" alt=""
                 class="w-10 h-10 rounded-full shrink-0 object-cover">
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ $post->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $post->user->program }} · {{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <x-ui.badge type="project">PROJECT</x-ui.badge>
    </div>

    {{-- Title & Description --}}
    <h3 class="text-base font-bold font-heading text-gray-900 mb-1 line-clamp-2">
        {{ $post->title }}
    </h3>
    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $post->description }}</p>

    {{-- Skills --}}
    @if($post->skills->count())
        <div class="flex flex-wrap gap-1.5 mb-3">
            @foreach($post->skills->take(4) as $skill)
                <x-ui.chip>{{ $skill->name }}</x-ui.chip>
            @endforeach
        </div>
    @endif

    {{-- Footer --}}
    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
        <div class="flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            Deadline {{ $post->deadline?->format('d M') ?? 'Fleksibel' }}
        </div>
        <a href="{{ route('post.show', $post) }}">
            <x-ui.button variant="outlined" size="sm">Tertarik</x-ui.button>
        </a>
    </div>
</article>
```

---

## 8. Halaman Feed (`feed/index.blade.php`)

```blade
@extends('layouts.app')
@section('title', 'Feed')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-4">

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-1 overflow-x-auto pb-2 mb-4 no-scrollbar border-b border-border">
        @foreach(['Semua' => null, 'Diskusi' => 'discussion', 'Project' => 'project'] as $label => $type)
            <a href="{{ route('feed.index', $type ? ['type' => $type] : []) }}"
               class="shrink-0 px-4 py-2.5 text-sm font-medium rounded-t transition-colors
                      {{ request('type') === $type ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
            </a>
        @endforeach
        <div class="ml-auto shrink-0">
            <button id="filter-btn"
                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600
                           border border-border rounded-pill hover:bg-gray-50">
                {{-- Filter icon --}}
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                </svg>
                Filter
            </button>
        </div>
    </div>

    {{-- Feed List --}}
    <div class="space-y-3">
        @forelse($posts as $post)
            @if($post->type === 'project')
                <x-card.project :post="$post" />
            @else
                <x-card.discussion :post="$post" />
            @endif
        @empty
            {{-- Empty state --}}
            <div class="text-center py-16">
                <div class="text-4xl mb-3">📭</div>
                <h3 class="text-base font-semibold text-gray-700 mb-1">Belum ada post</h3>
                <p class="text-sm text-gray-400">Jadilah yang pertama posting sesuatu!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $posts->links() }}</div>
</div>

{{-- FAB --}}
<a href="{{ route('post.create') }}"
   class="fixed bottom-20 right-5 md:bottom-8 w-14 h-14 bg-accent rounded-full shadow-fab
          flex items-center justify-center text-white hover:bg-orange-600 transition-colors z-30">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
    </svg>
</a>

{{-- Filter Bottom Sheet --}}
@include('components.modals.filter-sheet')
@endsection
```

---

## 9. Halaman Auth (`auth/activate.blade.php`)

```blade
@extends('layouts.auth')
@section('title', 'Aktivasi Akun')

@section('content')
<div class="space-y-6">

    {{-- Logo --}}
    <div class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-9">
    </div>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Aktivasi Akun Kamu</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Masukkan email kampus BSI untuk memulai.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('auth.send-otp') }}" method="POST" class="space-y-4">
        @csrf
        <x-ui.input
            name="email"
            type="email"
            label="Email Kampus"
            placeholder="nama@bsi.ac.id"
            :error="$errors->first('email')"
            helper="Hanya email @bsi.ac.id yang diterima"
            :value="old('email')"
            autocomplete="email"
            required />

        <x-ui.button type="submit" variant="primary" :full="true">
            Kirim Kode OTP
        </x-ui.button>
    </form>

    {{-- Footer --}}
    <p class="text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Masuk di sini</a>
    </p>
</div>
@endsection
```

---

## 10. Dark Mode

Implementasi dark mode menggunakan Tailwind `darkMode: 'class'`. Toggle via Alpine.js:

```blade
{{-- Settings toggle --}}
<div x-data="{ dark: document.documentElement.classList.contains('dark') }">
    <button
        @click="
            dark = !dark;
            document.documentElement.classList.toggle('dark', dark);
            fetch('{{ route('settings.dark-mode') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                body: JSON.stringify({ dark_mode: dark })
            });
        "
        class="relative w-11 h-6 rounded-full transition-colors"
        :class="dark ? 'bg-primary' : 'bg-gray-200'">
        <span class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform"
              :class="dark ? 'translate-x-5' : 'translate-x-0'">
        </span>
    </button>
</div>
```

Dark mode Tailwind class contoh:
```blade
<div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
```

---

## 11. Bottom Navigation (`components/bottom-nav.blade.php`)

```blade
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-border h-16 flex md:hidden">
    @php
    $items = [
        ['route' => 'feed.index',           'icon' => 'home',    'label' => 'Home'],
        ['route' => 'search.index',          'icon' => 'search',  'label' => 'Explore'],
        ['route' => 'notifications.index',   'icon' => 'bell',    'label' => 'Notif',
         'badge' => auth()->user()?->unread_notifications_count],
        ['route' => 'profile.show',          'icon' => 'user',    'label' => 'Profil'],
    ];
    @endphp

    @foreach($items as $item)
    @php $active = request()->routeIs($item['route']); @endphp
    <a href="{{ route($item['route']) }}"
       class="flex-1 flex flex-col items-center justify-center gap-0.5 relative
              {{ $active ? 'text-primary' : 'text-gray-400' }}">
        {{-- icon via inline SVG or Lucide CDN --}}
        <span class="text-lg">
            @if($item['icon'] === 'home') 🏠
            @elseif($item['icon'] === 'search') 🔍
            @elseif($item['icon'] === 'bell') 🔔
            @elseif($item['icon'] === 'user') 👤
            @endif
        </span>
        <span class="text-[10px] font-medium">{{ $item['label'] }}</span>
        @if(!empty($item['badge']) && $item['badge'] > 0)
            <span class="absolute top-1.5 right-[calc(50%-8px)] w-4 h-4 text-[9px] font-bold
                         bg-red-500 text-white rounded-full flex items-center justify-center">
                {{ $item['badge'] > 9 ? '9+' : $item['badge'] }}
            </span>
        @endif
    </a>
    @endforeach
</nav>
```

---

## 12. Konvensi Penamaan

| Tipe | Konvensi | Contoh |
|---|---|---|
| Blade component | kebab-case | `<x-card.project>`, `<x-ui.button>` |
| Route name | dot.notation | `feed.index`, `post.show`, `auth.login` |
| CSS class custom | prefix `bc-` | `bc-feed-card`, `bc-fab` |
| JS Alpine component | camelCase | `filterSheet`, `otpInput` |
| Image assets | kebab-case | `biconnect-logo.png`, `avatar-placeholder.png` |

---

## 13. Asset Placement

```
public/
├── images/
│   ├── biconnect-logo.png        ← Logo utama (transparent bg)
│   ├── biconnect-logo-white.png  ← Logo untuk dark bg (footer)
│   └── avatar-placeholder.png
resources/
├── css/
│   └── app.css
└── js/
    └── app.js
```

---

## 14. Dependencies yang Digunakan

```bash
# Laravel packages
composer require laravel/sanctum
composer require intervention/image  # untuk resize avatar

# NPM
npm install -D tailwindcss postcss autoprefixer
npm install alpinejs                  # untuk interaktif (bottom sheet, toggle, dll)

# Optional
npm install lucide                    # icon library
```

---

## 15. Checklist Implementasi

- [ ] Vite + Tailwind configured
- [ ] Google Fonts loaded via CSS
- [ ] `layouts/app.blade.php` dengan navbar + footer + bottom nav
- [ ] `layouts/auth.blade.php` centered card
- [ ] Komponen UI: button, input, chip, badge, avatar
- [ ] Komponen card: discussion, project
- [ ] Footer dark dengan logo BiConnect
- [ ] Halaman: landing, aktivasi, OTP, password, login, onboarding
- [ ] Halaman: feed, create post, post detail
- [ ] Halaman: profil (own + other), edit profil
- [ ] Halaman: notifikasi, settings, report
- [ ] Admin dashboard dengan sidebar
- [ ] Dark mode toggle di settings
- [ ] FAB (create post) di feed
- [ ] Bottom sheet filter (Alpine.js)

---

*GEMINI.md · BiConnect v1.0 · Laravel Blade + Vite + Tailwind CSS*
