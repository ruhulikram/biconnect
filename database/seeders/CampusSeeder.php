<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campuses = [
            // Region: Wilayah DKI Jakarta
            ['code' => 'Kramat 98', 'name' => 'Kramat 98 (Pusat)', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Pemuda', 'name' => 'Pemuda', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Salemba 22 & 45', 'name' => 'Salemba 22 & 45', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Kramat 168', 'name' => 'Kramat 168', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Dewisartika A & B', 'name' => 'Dewisartika A & B', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Kalimalang', 'name' => 'Kalimalang', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Jatiwaringin', 'name' => 'Jatiwaringin', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Fatmawati', 'name' => 'Fatmawati', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Warung Jati', 'name' => 'Warung Jati', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Cengkareng', 'name' => 'Cengkareng', 'region' => 'Wilayah DKI Jakarta'],
            ['code' => 'Slipi', 'name' => 'Slipi', 'region' => 'Wilayah DKI Jakarta'],

            // Region: Wilayah Jawa Barat & Banten
            ['code' => 'Margonda', 'name' => 'Margonda', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Bogor A, B & Cilebut', 'name' => 'Bogor A, B & Cilebut', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'BSD', 'name' => 'BSD', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Ciledug', 'name' => 'Ciledug', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Bekasi (Cut Mutia & Kaliabang)', 'name' => 'Bekasi (Cut Mutia & Kaliabang)', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Cibitung', 'name' => 'Cibitung', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Cikarang', 'name' => 'Cikarang', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Sukabumi', 'name' => 'Sukabumi', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Karawang', 'name' => 'Karawang', 'region' => 'Wilayah Jawa Barat & Banten'],
            ['code' => 'Cikampek', 'name' => 'Cikampek', 'region' => 'Wilayah Jawa Barat & Banten'],

            // Region: PSDKU (Program Studi di Luar Kampus Utama)
            ['code' => 'Tasikmalaya', 'name' => 'Tasikmalaya', 'region' => 'PSDKU'],
            ['code' => 'Tegal', 'name' => 'Tegal', 'region' => 'PSDKU'],
            ['code' => 'Purwokerto', 'name' => 'Purwokerto', 'region' => 'PSDKU'],
            ['code' => 'Surakarta', 'name' => 'Surakarta', 'region' => 'PSDKU'],
            ['code' => 'Yogyakarta', 'name' => 'Yogyakarta', 'region' => 'PSDKU'],
            ['code' => 'Pontianak', 'name' => 'Pontianak', 'region' => 'PSDKU'],
        ];

        foreach ($campuses as $campus) {
            Campus::updateOrCreate(
                ['code' => $campus['code']],
                ['name' => $campus['name'], 'region' => $campus['region']]
            );
        }

        // Backfill existing users/posts with old values to new clean codes
        $mappings = [
            'Kampus Rektorat/Kramat 98' => 'Kramat 98',
            'Kampus Kramat 18' => 'Kramat 168',
            'Kampus Salemba' => 'Salemba 22 & 45',
            'Kampus Dewi Sartika (Cawang)' => 'Dewisartika A & B',
            'Kampus Kalimalang' => 'Kalimalang',
            'Kampus Fatmawati' => 'Fatmawati',
            'Kampus Cengkareng' => 'Cengkareng',
            'Kampus Pemuda (Rawamangun)' => 'Pemuda',
            'Kampus Jatiwaringin' => 'Jatiwaringin',
            'Kampus Ciledug' => 'Ciledug',
            'Kampus Bekasi' => 'Bekasi (Cut Mutia & Kaliabang)',
            'Kampus BSD' => 'BSD',
            'Kampus Margonda' => 'Margonda',
            'Kampus Sukabumi' => 'Sukabumi',
            'Kampus Karawang' => 'Karawang',
            'Kampus Cikampek' => 'Cikampek',
            'Kampus Cibitung' => 'Cibitung',
            'Kampus Purwokerto' => 'Purwokerto',
            'Kampus Surakarta (Solo)' => 'Surakarta',
            'Kampus Yogyakarta' => 'Yogyakarta',
            'Kampus Pontianak' => 'Pontianak',
        ];

        foreach ($mappings as $old => $new) {
            DB::table('users')->where('campus_area', $old)->update(['campus_area' => $new]);
            DB::table('posts')->where('campus_area', $old)->update(['campus_area' => $new]);
        }
    }
}
