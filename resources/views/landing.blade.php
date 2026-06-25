@extends('layouts.landing')

@section('content')

{{-- ═══════ VERTICAL CAROUSEL HERO ═══════ --}}
<section x-data="heroCarousel()" class="relative bg-white dark:bg-gray-900 transition-colors overflow-hidden">
    <div class="min-h-[90vh] relative">

        {{-- Slides container --}}
        <div class="absolute inset-0">
            {{-- Slide 1 --}}
            <div x-show="active === 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8"
                 class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,#EEF2FF,white_60%)] dark:bg-[radial-gradient(ellipse_at_top_right,#1e3a8a,transparent_60%)]"></div>
            {{-- Slide 2 --}}
            <div x-show="active === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8"
                 class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,#FFF0EB,white_60%)] dark:bg-[radial-gradient(ellipse_at_top_left,#7c2d12,transparent_60%)]"></div>
            {{-- Slide 3 --}}
            <div x-show="active === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8"
                 class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,#ECFDF5,white_60%)] dark:bg-[radial-gradient(ellipse_at_bottom_right,#064e3b,transparent_60%)]"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col justify-center items-center text-center max-w-2xl mx-auto px-6 pt-10 pb-20 min-h-[90vh]"
             @touchstart="touchStart = $event.touches[0].clientY"
             @touchend="handleSwipe($event)"
             @wheel.passive="handleWheel($event)">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-pill bg-primary-light text-primary text-sm font-semibold mb-6 shadow-sm border border-primary/10 dark:bg-primary/10 dark:text-primary-light dark:border-primary/20">
                <span>✦</span> Khusus Mahasiswa BSI Terverifikasi
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl md:text-5xl font-bold font-heading text-gray-900 dark:text-white leading-tight tracking-tight mb-6 transition-colors">
                <span x-show="active === 0">Kolaborasi Project, Bangun Portofolio, Tumbuh Bersama</span>
                <span x-show="active === 1" x-cloak>Temukan Partner Project Lintas Jurusan</span>
                <span x-show="active === 2" x-cloak>Bangun Rekam Jejak Digital yang Solid</span>
            </h1>

            {{-- Subtext --}}
            <p class="text-base md:text-lg text-gray-500 dark:text-gray-400 max-w-lg mx-auto mb-10 leading-relaxed transition-colors">
                <span x-show="active === 0">BiConnect adalah platform eksklusif untuk mencari rekan tim lintas jurusan, berbagi ide, dan membangun rekam jejak project yang terverifikasi.</span>
                <span x-show="active === 1" x-cloak>Butuh backend engineer? UI designer? Data analyst? Temukan rekan dari berbagai program studi BSI yang siap berkolaborasi.</span>
                <span x-show="active === 2" x-cloak>Setiap kontribusi dan project yang kamu ikuti tercatat sebagai portofolio terverifikasi — siap untuk dunia kerja.</span>
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto mb-8">
                <x-ui.button variant="primary" size="lg" :href="route('auth.activate')" class="w-full sm:w-auto shadow-lg shadow-primary/20">
                    Aktivasi Pakai Email Kampus
                </x-ui.button>
                <x-ui.button variant="outlined" size="lg" href="#fitur" class="w-full sm:w-auto bg-white/70 dark:bg-gray-800/50 backdrop-blur-sm">
                    Pelajari Lebih Lanjut
                </x-ui.button>
            </div>

            {{-- Caption --}}
            <div class="flex items-center justify-center gap-4 text-xs font-medium text-gray-400">
                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Gratis</span>
                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Khusus @bsi.ac.id</span>
                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Terverifikasi</span>
            </div>

        </div>

        {{-- Navigation arrows (desktop) --}}
        <div class="hidden md:block">
            <button @click="prev()" aria-label="Slide sebelumnya"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
            </button>
            <button @click="next()" aria-label="Slide berikutnya"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </button>
        </div>

        {{-- Dots indicator --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            <button @click="active = 0" :class="active === 0 ? 'bg-primary w-6' : 'bg-gray-300 dark:bg-gray-600 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
            <button @click="active = 1" :class="active === 1 ? 'bg-primary w-6' : 'bg-gray-300 dark:bg-gray-600 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
            <button @click="active = 2" :class="active === 2 ? 'bg-primary w-6' : 'bg-gray-300 dark:bg-gray-600 w-2.5'" class="h-2.5 rounded-full transition-all duration-300"></button>
        </div>
    </div>
</section>

{{-- ═══════ FEATURES SECTION ═══════ --}}
<section id="fitur" class="py-24 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 transition-colors">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-heading text-gray-900 dark:text-white transition-colors">Apa yang bisa kamu lakukan?</h2>
            <p class="mt-4 text-gray-500 dark:text-gray-400 transition-colors">Tiga pilar utama untuk mendukung perjalanan akademik dan karirmu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card 1 — Post Project & Diskusi --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                <div class="w-14 h-14 mx-auto rounded-xl bg-primary-light dark:bg-primary/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('storage/icon/idea.png') }}" alt="Ide & Diskusi" class="w-8 h-8 object-contain">
                </div>
                <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">Post Project & Diskusi</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                    Bagikan ide project yang sedang kamu bangun, atau buka forum diskusi terkait kesulitan pemrograman dan tugas kuliah.
                </p>
            </div>

            {{-- Card 2 — Kolaborasi --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                <div class="w-14 h-14 mx-auto rounded-xl bg-accent-light dark:bg-orange-900/20 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('storage/icon/group.png') }}" alt="Kolaborasi" class="w-8 h-8 object-contain">
                </div>
                <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">Kolaborasi Lintas Jurusan</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                    Butuh designer? Atau programmer? Temukan rekan tim yang tepat dari berbagai program studi untuk melengkapi keahlianmu.
                </p>
            </div>

            {{-- Card 3 — Portofolio --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-card p-8 hover:shadow-md transition-all group text-center">
                <div class="w-14 h-14 mx-auto rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('storage/icon/deal.png') }}" alt="Portofolio" class="w-8 h-8 object-contain">
                </div>
                <h3 class="text-lg font-bold font-heading text-gray-900 dark:text-white mb-3 transition-colors">Bangun Portofolio Terverifikasi</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm transition-colors">
                    Catat kontribusimu di setiap project dan kumpulkan rekam jejak digital yang solid untuk persiapan melamar kerja nanti.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════ STATS SECTION ═══════ --}}
<section class="bg-primary py-20 relative overflow-hidden">
    {{-- Decorative background --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:40px_40px]"></div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 text-center divide-y sm:divide-y-0 sm:divide-x divide-white/20">

            <div class="pt-6 sm:pt-0">
                <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">1.000+</div>
                <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Mahasiswa</div>
            </div>

            <div class="pt-6 sm:pt-0">
                <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">500+</div>
                <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Project</div>
            </div>

            <div class="pt-6 sm:pt-0">
                <div class="text-4xl md:text-5xl font-black font-heading text-white mb-2 tracking-tight">50+</div>
                <div class="text-primary-light text-sm font-medium uppercase tracking-wider">Kolaborasi</div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function heroCarousel() {
    return {
        active: 0,
        totalSlides: 3,
        touchStart: 0,
        touchEnd: 0,
        autoAdvance: null,

        init() {
            this.startAutoAdvance();
        },

        startAutoAdvance() {
            this.autoAdvance = setInterval(() => {
                this.next();
            }, 5000);
        },

        resetAutoAdvance() {
            clearInterval(this.autoAdvance);
            this.startAutoAdvance();
        },

        next() {
            this.active = (this.active + 1) % this.totalSlides;
            this.resetAutoAdvance();
        },

        prev() {
            this.active = (this.active - 1 + this.totalSlides) % this.totalSlides;
            this.resetAutoAdvance();
        },

        handleSwipe(event) {
            this.touchEnd = event.changedTouches[0].clientY;
            const diff = this.touchStart - this.touchEnd;
            // Swipe up (next) or down (prev) with ~50px threshold
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
        },

        handleWheel(event) {
            // Only trigger on desktop, throttle with debounce
            if (window.innerWidth >= 768) {
                const now = Date.now();
                if (!this._lastWheel || now - this._lastWheel > 800) {
                    this._lastWheel = now;
                    if (event.deltaY > 30) {
                        this.next();
                    } else if (event.deltaY < -30) {
                        this.prev();
                    }
                }
            }
        }
    };
}
</script>
@endpush
