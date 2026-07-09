<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('dark', val => { localStorage.setItem('theme', val ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', val) })"
    :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiConnect — Platform Kolaborasi Mahasiswa BSI</title>
    <meta name="description"
        content="Platform kolaborasi project, mentoring, dan diskusi mahasiswa Universitas Bina Sarana Informatika.">
    <link rel="icon" href="{{ asset('images/icon-biconnect.webp') }}" type="image/webp">

    <!-- Google Fonts Preconnect & Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-body text-gray-900 dark:text-gray-100 antialiased bg-white dark:bg-gray-900 flex flex-col min-h-screen transition-colors">

    {{-- Sticky Header --}}
    <header
        class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/biconnect-logo.webp') }}" alt="BiConnect" width="128" height="32"
                    class="h-8 w-auto">
            </a>
            <div class="flex items-center gap-4">
                {{-- Theme Switcher --}}
                <button @click="dark = !dark" type="button" aria-label="Ubah tema"
                    class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                    <span class="sr-only">Ubah tema gelap atau terang</span>
                    <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0118 15.75 9.75 9.75 0 018.25 6c0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25 9.75 9.75 0 0012.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg x-show="dark" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-2.25l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>

                <a href="{{ route('login') }}"
                    class="text-sm font-semibold text-primary hover:text-primary-dark dark:text-white dark:hover:text-primary-light transition-colors">
                    Masuk
                </a>
                <a href="{{ route('auth.activate') }}"
                    class="hidden sm:inline-flex px-4 py-2 text-sm font-semibold bg-primary text-white rounded-input hover:bg-primary-dark transition-colors shadow-sm">
                    Aktivasi
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

</body>

</html>