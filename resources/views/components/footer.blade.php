<footer class="bg-[#1a1a1a] text-gray-400 pt-12 pb-6">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">

        {{-- 4-column grid (only for guests) --}}
        @guest
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-white/10">

            {{-- Col 1: Brand --}}
            <div class="space-y-4">
                <img src="{{ asset('images/biconnect-logo-footer.png') }}" alt="BiConnect Logo" class="h-9 w-auto">
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
                    <li>
                        <a href="{{ route('feed.index') }}" class="hover:text-white transition-colors">Feed</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show') }}" class="hover:text-white transition-colors">Profil</a>
                    </li>
                    <li>
                        <a href="{{ route('feed.index') }}?type=project" class="hover:text-white transition-colors">Projects</a>
                    </li>
                    <li>
                        <a href="{{ route('notifications.index') }}" class="hover:text-white transition-colors">Notifikasi</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors">Portfolio</a>
                    </li>
                </ul>
            </div>

            {{-- Col 3: Information --}}
            <div>
                <h4 class="text-white text-sm font-semibold font-heading mb-4">Information</h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="#" class="hover:text-white transition-colors">Tim Kami</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors">Hubungi Kami</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors">Tentang BiConnect</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors">Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('settings.index') }}" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>

            {{-- Col 4: Contact --}}
            <div>
                <h4 class="text-white text-sm font-semibold font-heading mb-4">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        <span>Universitas Bina Sarana Informatika</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <a href="mailto:admin@biconnect.bsi.ac.id" class="hover:text-white transition-colors">
                            admin@biconnect.bsi.ac.id
                        </a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        <span>(021) 28534471</span>
                    </li>
                </ul>
            </div>
        </div>
        @endguest

        {{-- Copyright bar --}}
        <div class="pt-6 text-center text-xs text-gray-600">
            Copyright © {{ date('Y') }}
            <a href="https://bsi.ac.id" target="_blank" rel="noopener noreferrer"
               class="text-primary hover:text-primary-dark transition-colors mx-1">
                Biro Teknologi Informasi Universitas Bina Sarana Informatika
            </a>
            · Designed with <span class="text-red-500">❤</span> All rights reserved.
        </div>

    </div>
</footer>
