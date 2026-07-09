@extends('layouts.landing')

@section('content')

    {{-- ═══════ HORIZONTAL HERO WITH BANNER SLIDER ═══════ --}}
    <section class="relative bg-white dark:bg-gray-900 overflow-hidden min-h-[90vh] flex items-center transition-colors">
        <div class="max-w-6xl mx-auto px-6 w-full py-16 md:py-0">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

                {{-- Left side: Text & CTA --}}
                <div class="flex-1 text-center lg:text-left max-w-xl">

                    {{-- Badge --}}
                    <!-- <div
                                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-pill bg-primary-light text-primary text-sm font-semibold mb-6 shadow-sm border border-primary/10 dark:bg-primary/10 dark:text-primary-light dark:border-primary/20">
                                        <span>✦</span> Khusus Mahasiswa BSI Terverifikasi
                                    </div> -->

                    {{-- Headline --}}
                    <h1
                        class="text-4xl md:text-5xl font-bold font-heading text-gray-900 dark:text-white leading-tight tracking-tight mb-6">
                        Kolaborasi Project, Bangun Portofolio, Tumbuh Bersama
                    </h1>

                    {{-- Subtext --}}
                    <p class="text-base md:text-lg text-gray-500 dark:text-gray-400 leading-relaxed mb-8">
                        BiConnect adalah platform eksklusif untuk mencari rekan tim lintas jurusan, berbagi ide, dan
                        membangun rekam jejak project yang terverifikasi.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center lg:items-start gap-4 mb-6">
                        <x-ui.button variant="primary" size="lg" :href="route('auth.activate')"
                            class="w-full sm:w-auto shadow-lg shadow-primary/20">
                            Aktivasi Pakai Email Kampus
                        </x-ui.button>
                        <x-ui.button variant="outlined" size="lg" href="#fitur"
                            class="w-full sm:w-auto bg-white/70 dark:bg-gray-800/50 backdrop-blur-sm">
                            Pelajari Lebih Lanjut
                        </x-ui.button>
                    </div>

                    <!-- {{-- Caption --}}
                                <div class="flex items-center justify-center lg:justify-start gap-4 text-xs font-medium text-gray-400">
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none"
                                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg> Gratis</span>
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none"
                                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg> Khusus @bsi.ac.id</span>
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none"
                                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg> Terverifikasi</span>
                                </div> -->
                </div>

                {{-- Right side: Auto-sliding banner --}}
                <div class="flex-1 w-full max-w-lg" x-data="{
                                                     active: 0,
                                                     total: 3,
                                                     timer: null,
                                                     init() {
                                                         this.timer = setInterval(() => {
                                                             this.active = (this.active + 1) % this.total;
                                                         }, 4500);
                                                     },
                                                     goTo(idx) {
                                                         clearInterval(this.timer);
                                                         this.active = idx;
                                                         this.timer = setInterval(() => {
                                                             this.active = (this.active + 1) % this.total;
                                                         }, 4500);
                                                     }
                                                 }">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] bg-indigo-200">

                        {{-- Slide 1 --}}
                        <div x-show="active === 0" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-x-8"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-8"
                            class="absolute inset-0 bg-gradient-to-br from-indigo-200 to-purple-200 flex items-center justify-center">
                            <img src="{{ asset('images/banner.webp') }}" alt="Temukan Partner Project"
                                class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                        </div>

                        {{-- Slide 2 --}}
                        <div x-show="active === 1" style="display:none"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-x-8"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-8"
                            class="absolute inset-0 bg-gradient-to-br from-orange-200 to-amber-200 flex items-center justify-center">
                            <img src="{{ asset('images/banner-2.webp') }}" alt="Bangun Portofolio"
                                class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                        </div>

                        {{-- Slide 3 --}}
                        <div x-show="active === 2" style="display:none"
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-x-8"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-8"
                            class="absolute inset-0 bg-gradient-to-br from-emerald-200 to-teal-200 flex items-center justify-center">
                            <img src="{{ asset('images/banner-3.webp') }}" alt="Diskusi & Bertukar Ide"
                                class="absolute inset-0 w-full h-full object-cover" onerror="this.remove()">
                        </div>

                        {{-- Dots navigasi --}}
                        <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex items-center gap-0.5 z-20">
                            <button @click="goTo(0)" aria-label="Tampilkan slide 1" class="w-12 h-12 flex items-center justify-center focus:outline-none">
                                <span :class="active === 0 ? 'w-6 bg-primary' : 'w-2 bg-white/70'" class="h-2 rounded-full transition-all duration-300 shadow"></span>
                            </button>
                            <button @click="goTo(1)" aria-label="Tampilkan slide 2" class="w-12 h-12 flex items-center justify-center focus:outline-none">
                                <span :class="active === 1 ? 'w-6 bg-primary' : 'w-2 bg-white/70'" class="h-2 rounded-full transition-all duration-300 shadow"></span>
                            </button>
                            <button @click="goTo(2)" aria-label="Tampilkan slide 3" class="w-12 h-12 flex items-center justify-center focus:outline-none">
                                <span :class="active === 2 ? 'w-6 bg-primary' : 'w-2 bg-white/70'" class="h-2 rounded-full transition-all duration-300 shadow"></span>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
    </section>

    {{-- ═══════ FEATURES SECTION ═══════ --}}
    <section id="fitur"
        class="py-24 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 transition-colors">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold font-heading text-gray-900 dark:text-white transition-colors">Apa yang bisa
                    kamu lakukan?</h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 transition-colors">Tiga pilar utama untuk mendukung
                    perjalanan akademik dan karirmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Card 1 — Post Project & Diskusi --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                    <div
                        class="w-14 h-14 mx-auto rounded-xl bg-primary-light dark:bg-primary/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <img src="{{ asset('storage/icon/idea.png') }}" alt="Ide & Diskusi" class="w-8 h-8 object-contain">
                    </div>
                    <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">Post
                        Project & Diskusi</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                        Bagikan ide project yang sedang kamu bangun, atau buka forum diskusi terkait kesulitan pemrograman
                        dan tugas kuliah.
                    </p>
                </div>

                {{-- Card 2 — Kolaborasi --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                    <div
                        class="w-14 h-14 mx-auto rounded-xl bg-accent-light dark:bg-orange-900/20 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <img src="{{ asset('storage/icon/group.png') }}" alt="Kolaborasi" class="w-8 h-8 object-contain">
                    </div>
                    <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">
                        Kolaborasi Lintas Jurusan</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                        Butuh designer? Atau programmer? Temukan rekan tim yang tepat dari berbagai program studi untuk
                        melengkapi keahlianmu.
                    </p>
                </div>

                {{-- Card 3 — Portofolio --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                    <div
                        class="w-14 h-14 mx-auto rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <img src="{{ asset('storage/icon/deal.png') }}" alt="Portofolio" class="w-8 h-8 object-contain">
                    </div>
                    <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">Bangun
                        Portofolio Terverifikasi</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                        Catat kontribusimu di setiap project dan kumpulkan rekam jejak digital yang solid untuk persiapan
                        melamar kerja nanti.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════ STATS SECTION ═══════ --}}
    <section class="bg-primary py-20 relative overflow-hidden">
        {{-- Decorative background --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:40px_40px]">
        </div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div
                class="grid grid-cols-1 sm:grid-cols-3 gap-10 text-center divide-y sm:divide-y-0 sm:divide-x divide-white/20">

                <div class="pt-6 sm:pt-0">
                    <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">
                        {{ number_format($stats['users']) }}+
                    </div>
                    <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Mahasiswa</div>
                </div>

                <div class="pt-6 sm:pt-0">
                    <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">
                        {{ number_format($stats['projects']) }}+
                    </div>
                    <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Project</div>
                </div>

                <div class="pt-6 sm:pt-0">
                    <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">
                        {{ number_format($stats['interests']) }}+
                    </div>
                    <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Kolaborasi</div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function bannerSlider() {
            return {
                active: 0,
                autoAdvance: null,

                init() {
                    this.startAutoAdvance();
                },

                startAutoAdvance() {
                    this.autoAdvance = setInterval(() => {
                        this.active = (this.active + 1) % 3;
                    }, 4500);
                },

                resetAutoAdvance() {
                    clearInterval(this.autoAdvance);
                    this.startAutoAdvance();
                }
            };
        }
    </script>
@endpush