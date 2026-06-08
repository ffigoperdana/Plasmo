<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HospitalSeeder extends Seeder
{
    public function run()
    {
        $hospitals = [
            [
                'name' => 'RS Advent Bandung',
                'address' => 'Jl. Cihampelas No. 161, Bandung',
                'hotline' => '6281234567890',
                'type' => 'rumah-sakit',
                'stok_plasma_a_positif' => 5,
                'stok_plasma_a_negatif' => 2,
                'stok_plasma_b_positif' => 8,
                'stok_plasma_b_negatif' => 1,
                'stok_plasma_ab_positif' => 3,
                'stok_plasma_ab_negatif' => 0,
                'stok_plasma_o_positif' => 10,
                'stok_plasma_o_negatif' => 4,
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'name' => 'RS Hasan Sadikin',
                'address' => 'Jl. Pasteur No. 38, Bandung',
                'hotline' => '6281298765432',
                'type' => 'rumah-sakit',
                'stok_plasma_a_positif' => 12,
                'stok_plasma_a_negatif' => 3,
                'stok_plasma_b_positif' => 6,
                'stok_plasma_b_negatif' => 2,
                'stok_plasma_ab_positif' => 4,
                'stok_plasma_ab_negatif' => 1,
                'stok_plasma_o_positif' => 15,
                'stok_plasma_o_negatif' => 5,
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'name' => 'RS Borromeus',
                'address' => 'Jl. Ir. H. Juanda No. 100, Bandung',
                'hotline' => '6281356789012',
                'type' => 'rumah-sakit',
                'stok_plasma_a_positif' => 7,
                'stok_plasma_a_negatif' => 1,
                'stok_plasma_b_positif' => 4,
                'stok_plasma_b_negatif' => 0,
                'stok_plasma_ab_positif' => 2,
                'stok_plasma_ab_negatif' => 1,
                'stok_plasma_o_positif' => 9,
                'stok_plasma_o_negatif' => 3,
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'UDD PMI Kota Bandung',
                'address' => 'Jl. Aceh No. 79, Bandung',
                'hotline' => '6281200112233',
                'type' => 'udd',
                'stok_plasma_a_positif' => 20,
                'stok_plasma_a_negatif' => 5,
                'stok_plasma_b_positif' => 14,
                'stok_plasma_b_negatif' => 3,
                'stok_plasma_ab_positif' => 6,
                'stok_plasma_ab_negatif' => 2,
                'stok_plasma_o_positif' => 25,
                'stok_plasma_o_negatif' => 8,
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'RS Santo Yusuf',
                'address' => 'Jl. Cikutra No. 7, Bandung',
                'hotline' => '6281377889900',
                'type' => 'rumah-sakit',
                'stok_plasma_a_positif' => 3,
                'stok_plasma_a_negatif' => 1,
                'stok_plasma_b_positif' => 5,
                'stok_plasma_b_negatif' => 2,
                'stok_plasma_ab_positif' => 1,
                'stok_plasma_ab_negatif' => 0,
                'stok_plasma_o_positif' => 7,
                'stok_plasma_o_negatif' => 2,
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Puskesmas Ibrahim Adjie',
                'address' => 'Jl. Ibrahim Adjie No. 88, Bandung',
                'hotline' => '6281344556677',
                'type' => 'puskesmas',
                'stok_plasma_a_positif' => 2,
                'stok_plasma_a_negatif' => 0,
                'stok_plasma_b_positif' => 3,
                'stok_plasma_b_negatif' => 1,
                'stok_plasma_ab_positif' => 1,
                'stok_plasma_ab_negatif' => 0,
                'stok_plasma_o_positif' => 4,
                'stok_plasma_o_negatif' => 1,
                'created_at' => Carbon::now(),
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
