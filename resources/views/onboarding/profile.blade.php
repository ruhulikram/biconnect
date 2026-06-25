@extends('layouts.auth')
@section('title', 'Lengkapi Profil')

@section('content')
<div class="space-y-6">

    {{-- Progress --}}
    <div class="space-y-2">
        <div class="flex justify-between items-center text-xs font-medium text-gray-500">
            <span>Langkah 1 dari 2</span>
            <span>Profil</span>
        </div>
        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 50%"></div>
        </div>
    </div>

    {{-- Logo & Heading --}}
    <div class="text-center pt-2">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-10 w-auto mx-auto mb-4">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Lengkapi Profil Kamu</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Bantu teman kampus mengenalmu lebih baik.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('onboarding.save-profile') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <x-ui.input
            name="name"
            label="Nama Lengkap"
            placeholder="Masukkan nama lengkap"
            :value="old('name', $user->name)"
            :error="$errors->first('name')"
            required />

        {{-- Program Studi --}}
        <div class="space-y-1.5">
            <label for="program" class="block text-xs font-medium text-gray-700">Program Studi</label>
            <div class="relative">
                <select id="program" name="program" required
                        class="w-full h-12 rounded-input border bg-white px-4 py-3 text-sm text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus appearance-none
                               {{ $errors->has('program') ? 'border-red-500' : 'border-border' }}">
                    <option value="" disabled {{ old('program', $user->program) ? '' : 'selected' }}>Pilih Program Studi</option>
                    
                    <optgroup label="Fakultas Teknik & Informatika">
                        <option value="S1 - Sistem Informasi" {{ old('program', $user->program) == 'S1 - Sistem Informasi' ? 'selected' : '' }}>S1 - Sistem Informasi</option>
                        <option value="S1 - Teknologi Informasi" {{ old('program', $user->program) == 'S1 - Teknologi Informasi' ? 'selected' : '' }}>S1 - Teknologi Informasi</option>
                        <option value="S1 - Ilmu Komputer" {{ old('program', $user->program) == 'S1 - Ilmu Komputer' ? 'selected' : '' }}>S1 - Ilmu Komputer</option>
                        <option value="S1 - Rekayasa Perangkat Lunak" {{ old('program', $user->program) == 'S1 - Rekayasa Perangkat Lunak' ? 'selected' : '' }}>S1 - Rekayasa Perangkat Lunak</option>
                        <option value="S1 - Informatika" {{ old('program', $user->program) == 'S1 - Informatika' ? 'selected' : '' }}>S1 - Informatika</option>
                        <option value="S1 - Teknik Industri" {{ old('program', $user->program) == 'S1 - Teknik Industri' ? 'selected' : '' }}>S1 - Teknik Industri</option>
                        <option value="S1 - Teknik Elektro" {{ old('program', $user->program) == 'S1 - Teknik Elektro' ? 'selected' : '' }}>S1 - Teknik Elektro</option>
                        <option value="S2 - Magister Teknologi Informasi" {{ old('program', $user->program) == 'S2 - Magister Teknologi Informasi' ? 'selected' : '' }}>S2 - Magister Teknologi Informasi</option>
                    </optgroup>

                    <optgroup label="Fakultas Ekonomi & Bisnis">
                        <option value="D3 - Administrasi Bisnis" {{ old('program', $user->program) == 'D3 - Administrasi Bisnis' ? 'selected' : '' }}>D3 - Administrasi Bisnis</option>
                        <option value="D3 - Perhotelan" {{ old('program', $user->program) == 'D3 - Perhotelan' ? 'selected' : '' }}>D3 - Perhotelan</option>
                        <option value="D3 - Manajemen Pajak" {{ old('program', $user->program) == 'D3 - Manajemen Pajak' ? 'selected' : '' }}>D3 - Manajemen Pajak</option>
                        <option value="S1 - Manajemen" {{ old('program', $user->program) == 'S1 - Manajemen' ? 'selected' : '' }}>S1 - Manajemen</option>
                        <option value="S1 - Akuntansi" {{ old('program', $user->program) == 'S1 - Akuntansi' ? 'selected' : '' }}>S1 - Akuntansi</option>
                        <option value="S1 - Pariwisata" {{ old('program', $user->program) == 'S1 - Pariwisata' ? 'selected' : '' }}>S1 - Pariwisata</option>
                        <option value="S2 - Magister Manajemen" {{ old('program', $user->program) == 'S2 - Magister Manajemen' ? 'selected' : '' }}>S2 - Magister Manajemen</option>
                        <option value="S2 - Magister Akuntansi" {{ old('program', $user->program) == 'S2 - Magister Akuntansi' ? 'selected' : '' }}>S2 - Magister Akuntansi</option>
                    </optgroup>

                    <optgroup label="Fakultas Komunikasi & Bahasa">
                        <option value="D3 - Ilmu Komunikasi" {{ old('program', $user->program) == 'D3 - Ilmu Komunikasi' ? 'selected' : '' }}>D3 - Ilmu Komunikasi</option>
                        <option value="D3 - Broadcasting" {{ old('program', $user->program) == 'D3 - Broadcasting' ? 'selected' : '' }}>D3 - Broadcasting</option>
                        <option value="D3 - Hubungan Masyarakat" {{ old('program', $user->program) == 'D3 - Hubungan Masyarakat' ? 'selected' : '' }}>D3 - Hubungan Masyarakat</option>
                        <option value="S1 - Ilmu Komunikasi" {{ old('program', $user->program) == 'S1 - Ilmu Komunikasi' ? 'selected' : '' }}>S1 - Ilmu Komunikasi</option>
                        <option value="S1 - Sastra Inggris" {{ old('program', $user->program) == 'S1 - Sastra Inggris' ? 'selected' : '' }}>S1 - Sastra Inggris</option>
                        <option value="S1 - Desain Komunikasi Visual (DKV)" {{ old('program', $user->program) == 'S1 - Desain Komunikasi Visual (DKV)' ? 'selected' : '' }}>S1 - Desain Komunikasi Visual (DKV)</option>
                    </optgroup>
                </select>
                {{-- Arrow icon --}}
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            @if($errors->has('program'))
                <p class="text-xs text-red-500">{{ $errors->first('program') }}</p>
            @endif
        </div>

        {{-- Kampus --}}
        <div class="space-y-1.5">
            <label for="campus_area" class="block text-xs font-medium text-gray-700">Kampus Area</label>
            <div class="relative">
                <select id="campus_area" name="campus_area" required
                        class="w-full h-12 rounded-input border bg-white px-4 py-3 text-sm text-gray-900 transition-shadow duration-150 focus:outline-none focus:border-primary focus:shadow-focus appearance-none
                               {{ $errors->has('campus_area') ? 'border-red-500' : 'border-border' }}">
                    <option value="" disabled {{ old('campus_area', $user->campus_area) ? '' : 'selected' }}>Pilih Kampus Area</option>
                    
                    <optgroup label="Wilayah DKI Jakarta">
                        <option value="Kampus Rektorat/Kramat 98" {{ old('campus_area', $user->campus_area) == 'Kampus Rektorat/Kramat 98' ? 'selected' : '' }}>Kramat 98 (Rektorat) - Jakarta Pusat</option>
                        <option value="Kampus Kramat 18" {{ old('campus_area', $user->campus_area) == 'Kampus Kramat 18' ? 'selected' : '' }}>Kramat 18 - Jakarta Pusat</option>
                        <option value="Kampus Salemba" {{ old('campus_area', $user->campus_area) == 'Kampus Salemba' ? 'selected' : '' }}>Salemba - Jakarta Pusat</option>
                        <option value="Kampus Dewi Sartika (Cawang)" {{ old('campus_area', $user->campus_area) == 'Kampus Dewi Sartika (Cawang)' ? 'selected' : '' }}>Dewi Sartika (Cawang) - Jakarta Timur</option>
                        <option value="Kampus Kalimalang" {{ old('campus_area', $user->campus_area) == 'Kampus Kalimalang' ? 'selected' : '' }}>Kalimalang - Jakarta Timur</option>
                        <option value="Kampus Fatmawati" {{ old('campus_area', $user->campus_area) == 'Kampus Fatmawati' ? 'selected' : '' }}>Fatmawati - Jakarta Selatan</option>
                        <option value="Kampus Cengkareng" {{ old('campus_area', $user->campus_area) == 'Kampus Cengkareng' ? 'selected' : '' }}>Cengkareng - Jakarta Barat</option>
                        <option value="Kampus Pemuda (Rawamangun)" {{ old('campus_area', $user->campus_area) == 'Kampus Pemuda (Rawamangun)' ? 'selected' : '' }}>Pemuda (Rawamangun) - Jakarta Timur</option>
                        <option value="Kampus Jatiwaringin" {{ old('campus_area', $user->campus_area) == 'Kampus Jatiwaringin' ? 'selected' : '' }}>Jatiwaringin - Jakarta Timur</option>
                        <option value="Kampus Ciledug" {{ old('campus_area', $user->campus_area) == 'Kampus Ciledug' ? 'selected' : '' }}>Ciledug - Jakarta</option>
                    </optgroup>

                    <optgroup label="Wilayah Jawa Barat & Banten">
                        <option value="Kampus Bekasi" {{ old('campus_area', $user->campus_area) == 'Kampus Bekasi' ? 'selected' : '' }}>Bekasi - Rawalumbu</option>
                        <option value="Kampus BSD" {{ old('campus_area', $user->campus_area) == 'Kampus BSD' ? 'selected' : '' }}>BSD - Tangerang Selatan</option>
                        <option value="Kampus Margonda" {{ old('campus_area', $user->campus_area) == 'Kampus Margonda' ? 'selected' : '' }}>Margonda - Depok</option>
                        <option value="Kampus Sukabumi" {{ old('campus_area', $user->campus_area) == 'Kampus Sukabumi' ? 'selected' : '' }}>Sukabumi</option>
                        <option value="Kampus Karawang" {{ old('campus_area', $user->campus_area) == 'Kampus Karawang' ? 'selected' : '' }}>Karawang</option>
                        <option value="Kampus Cikampek" {{ old('campus_area', $user->campus_area) == 'Kampus Cikampek' ? 'selected' : '' }}>Cikampek</option>
                        <option value="Kampus Cibitung" {{ old('campus_area', $user->campus_area) == 'Kampus Cibitung' ? 'selected' : '' }}>Cibitung - Bekasi</option>
                    </optgroup>

                    <optgroup label="PSDKU (Program Studi di Luar Kampus Utama)">
                        <option value="Kampus Purwokerto" {{ old('campus_area', $user->campus_area) == 'Kampus Purwokerto' ? 'selected' : '' }}>Purwokerto</option>
                        <option value="Kampus Surakarta (Solo)" {{ old('campus_area', $user->campus_area) == 'Kampus Surakarta (Solo)' ? 'selected' : '' }}>Surakarta (Solo)</option>
                        <option value="Kampus Yogyakarta" {{ old('campus_area', $user->campus_area) == 'Kampus Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                        <option value="Kampus Pontianak" {{ old('campus_area', $user->campus_area) == 'Kampus Pontianak' ? 'selected' : '' }}>Pontianak</option>
                    </optgroup>
                </select>
                {{-- Arrow icon --}}
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            @if($errors->has('campus_area'))
                <p class="text-xs text-red-500">{{ $errors->first('campus_area') }}</p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="pt-4 flex items-center gap-3">
            <button type="submit" formaction="{{ route('onboarding.skip') }}" formnovalidate
                    class="w-1/3 h-12 rounded-input border border-border text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors">
                Lewati
            </button>
            
            <button type="submit"
                    class="w-2/3 h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                           hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20 flex justify-center items-center gap-2">
                Lanjut
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </button>
        </div>

    </form>
</div>
@endsection
