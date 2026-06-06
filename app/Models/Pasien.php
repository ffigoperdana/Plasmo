<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Pasien
 *
 * Merepresentasikan data pasien yang membutuhkan donor
 * plasma darah dalam aplikasi Plasmo.
 *
 * @property int    $id
 * @property int    $user_id          ID pengguna terkait
 * @property string $full_name        Nama lengkap pasien
 * @property string $blood_type       Golongan darah
 * @property string $phone_number     Nomor telepon
 * @property string $address          Alamat
 * @property int    $age              Usia
 * @property string|null $medical_condition  Kondisi medis
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pemohon',
        'hotline',
        'nama_pasien',
        'gender',
        'age',
        'blood_type',
        'rhesus',
        'hospital',
        'hospital_room',
        'province',
        'city',
        'File_TPK',
        'Link_TPK',
        'jumlah_plasma',
        'vaccinated',
    ];

    /**
     * Relasi ke model User.
     *
     * Setiap data pasien dimiliki oleh satu pengguna (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
