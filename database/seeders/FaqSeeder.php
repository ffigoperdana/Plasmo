<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'pertanyaan' => 'Apa itu donor plasma konvalesen?',
                'jawaban' => 'Donor plasma konvalesen adalah proses pengambilan plasma darah dari pasien yang telah sembuh dari COVID-19. Plasma ini mengandung antibodi yang dapat membantu pasien lain melawan virus.',
            ],
            [
                'pertanyaan' => 'Siapa yang bisa menjadi pendonor plasma?',
                'jawaban' => 'Pendonor plasma harus berusia 18-60 tahun, berat badan minimal 55 kg, pernah terkonfirmasi COVID-19, dan sudah sembuh minimal 14 hari tanpa keluhan.',
            ],
            [
                'pertanyaan' => 'Apakah donor plasma berbahaya?',
                'jawaban' => 'Tidak. Proses donor plasma aman dan dilakukan oleh tenaga medis profesional. Tubuh akan meregenerasi plasma yang diambil dalam waktu 24-48 jam.',
            ],
            [
                'pertanyaan' => 'Berapa lama proses donor plasma?',
                'jawaban' => 'Proses donor plasma memakan waktu sekitar 30-60 menit, termasuk pemeriksaan awal dan istirahat setelah donor.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara mendaftar sebagai pendonor?',
                'jawaban' => 'Anda bisa mendaftar melalui aplikasi Plasmo dengan memilih menu "Daftar" kemudian pilih peran sebagai Pendonor. Lengkapi data diri dan tunggu verifikasi dari admin.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
