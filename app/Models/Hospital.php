<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Hospital
 *
 * Merepresentasikan data Rumah Sakit yang menyediakan layanan
 * plasma darah dalam aplikasi donor plasma Plasmo.
 *
 * @property int    $id
 * @property string $name                   Nama rumah sakit
 * @property string $address                Alamat rumah sakit
 * @property string $phone                  Nomor telepon
 * @property string $email                  Alamat email
 * @property string|null $website           Website rumah sakit
 * @property string|null $image             Path gambar/foto rumah sakit
 * @property int    $stok_plasma_a_positif  Stok plasma golongan A+
 * @property int    $stok_plasma_a_negatif  Stok plasma golongan A-
 * @property int    $stok_plasma_b_positif  Stok plasma golongan B+
 * @property int    $stok_plasma_b_negatif  Stok plasma golongan B-
 * @property int    $stok_plasma_ab_positif Stok plasma golongan AB+
 * @property int    $stok_plasma_ab_negatif Stok plasma golongan AB-
 * @property int    $stok_plasma_o_positif  Stok plasma golongan O+
 * @property int    $stok_plasma_o_negatif  Stok plasma golongan O-
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospital';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'hotline',
        'stok_plasma_a_positif',
        'stok_plasma_a_negatif',
        'stok_plasma_b_positif',
        'stok_plasma_b_negatif',
        'stok_plasma_ab_positif',
        'stok_plasma_ab_negatif',
        'stok_plasma_o_positif',
        'stok_plasma_o_negatif',
    ];

    /**
     * Nilai default untuk atribut stok plasma.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'stok_plasma_a_positif'  => 0,
        'stok_plasma_a_negatif'  => 0,
        'stok_plasma_b_positif'  => 0,
        'stok_plasma_b_negatif'  => 0,
        'stok_plasma_ab_positif' => 0,
        'stok_plasma_ab_negatif' => 0,
        'stok_plasma_o_positif'  => 0,
        'stok_plasma_o_negatif'  => 0,
    ];
}
