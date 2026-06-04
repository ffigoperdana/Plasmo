<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Plasmo
 *
 * Merepresentasikan data stok plasma darah per golongan darah
 * dalam sistem manajemen aplikasi donor plasma Plasmo.
 *
 * @property int    $id
 * @property string $name        Nama/label stok plasma
 * @property string $blood_type  Golongan darah
 * @property int    $stok_plasma Jumlah stok plasma yang tersedia
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Plasmo extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'blood_type',
        'stok_plasma',
    ];

    /**
     * Nilai default untuk atribut model.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'stok_plasma' => 0,
    ];
}
