<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'password'       => bcrypt('adminplasmo12'),
            'role_id'        => 1,
            'golongan_darah' => 'O+',
            'no_telepon'     => '6281200001111',
            'alamat'         => 'Bandung',
        ]);

        // Pencari Donor (Pasien)
        User::create([
            'name'           => 'Pasien Demo',
            'email'          => 'pasien@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 2,
            'golongan_darah' => 'A+',
            'no_telepon'     => '6281300002222',
            'alamat'         => 'Jl. Merdeka No. 10, Bandung',
            'usia'           => 28,
        ]);

        // Pendonor
        User::create([
            'name'           => 'Pendonor Demo',
            'email'          => 'pendonor@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 3,
            'golongan_darah' => 'A+',
            'no_telepon'     => '6281400003333',
            'alamat'         => 'Jl. Asia Afrika No. 5, Bandung',
            'usia'           => 32,
        ]);

        // Additional pendonor for list testing
        User::create([
            'name'           => 'Budi Santoso',
            'email'          => 'budi@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 3,
            'golongan_darah' => 'A+',
            'no_telepon'     => '6281500004444',
            'alamat'         => 'Jl. Braga No. 20, Bandung',
            'usia'           => 25,
        ]);

        User::create([
            'name'           => 'Siti Aminah',
            'email'          => 'siti@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 3,
            'golongan_darah' => 'B+',
            'no_telepon'     => '6281600005555',
            'alamat'         => 'Jl. Dago No. 15, Bandung',
            'usia'           => 29,
        ]);

        User::create([
            'name'           => 'Ahmad Fauzi',
            'email'          => 'ahmad@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 3,
            'golongan_darah' => 'O+',
            'no_telepon'     => '6281700006666',
            'alamat'         => 'Jl. Setiabudi No. 8, Bandung',
            'usia'           => 35,
        ]);

        User::create([
            'name'           => 'Dewi Lestari',
            'email'          => 'dewi@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 3,
            'golongan_darah' => 'AB+',
            'no_telepon'     => '6281800007777',
            'alamat'         => 'Jl. Pasteur No. 25, Bandung',
            'usia'           => 27,
        ]);

        // Pasien without golongan_darah (for testing incomplete profile flow)
        User::create([
            'name'           => 'User Baru',
            'email'          => 'baru@demo.com',
            'password'       => bcrypt('password123'),
            'role_id'        => 2,
            'golongan_darah' => null,
            'no_telepon'     => null,
            'alamat'         => null,
        ]);
    }
}
