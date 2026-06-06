<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Pendonor
 *
 * Merepresentasikan data pendonor plasma darah
 * dalam aplikasi Plasmo.
 *
 * @property int    $id
 * @property int    $user_id       ID pengguna terkait
 * @property string $full_name     Nama lengkap pendonor
 * @property string $blood_type    Golongan darah
 * @property string $phone_number  Nomor telepon
 * @property string $address       Alamat
 * @property int    $age           Usia
 * @property int    $weight        Berat badan (kg)
 * @property string $plasma_status Status plasma (misal: sudah pernah donor / belum)
 * @property bool   $ready         Status kesiapan untuk mendonor
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Pendonor extends Model
{
    use HasFactory;

    protected $table = 'pendonor';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pendonor',
        'hotline',
        'NIK',
        'gender',
        'age',
        'blood_type',
        'rhesus',
        'weight',
        'height',
        'province',
        'city',
        'kecamatan',
        'kelurahan',
        'alamat',
        'covid_infected',
        'donors',
        'donors_apheresis',
        'donors_hospital',
        'PCR_Positive',
        'PCR_Negative',
        'PCR_Positive_file',
        'PCR_Negative_file',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'PCR_Positive' => 'date',
        'PCR_Negative' => 'date',
    ];

    /**
     * Relasi ke model User.
     *
     * Setiap data pendonor dimiliki oleh satu pengguna (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
