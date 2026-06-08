<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $beritas = [
            [
                'judul_berita' => 'Stok Plasma Darah di Bandung Meningkat',
                'isi_berita' => 'Kabar baik datang dari kota Bandung. Stok plasma darah konvalesen di beberapa rumah sakit mengalami peningkatan signifikan berkat antusiasme masyarakat dalam mendonorkan plasmanya. RS Hasan Sadikin mencatat peningkatan donor sebesar 40% dalam sebulan terakhir.',
            ],
            [
                'judul_berita' => 'Cara Menjaga Kesehatan Setelah Donor Plasma',
                'isi_berita' => 'Setelah mendonorkan plasma, penting untuk menjaga asupan cairan dan nutrisi. Disarankan untuk minum air putih minimal 2 liter per hari, mengonsumsi makanan tinggi protein, dan beristirahat cukup selama 24 jam setelah donor.',
            ],
            [
                'judul_berita' => 'Webinar: Pentingnya Donor Plasma di Masa Pandemi',
                'isi_berita' => 'Plasmo bersama PMI mengadakan webinar gratis tentang pentingnya donor plasma konvalesen. Acara akan diselenggarakan pada hari Sabtu mendatang pukul 10.00 WIB melalui platform Zoom. Peserta akan mendapat e-sertifikat.',
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }
    }
}
