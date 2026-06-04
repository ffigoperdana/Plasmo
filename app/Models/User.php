<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model User
 *
 * Merepresentasikan pengguna yang terdaftar dalam aplikasi
 * donor plasma darah Plasmo. Pengguna dapat berperan sebagai
 * admin, pendonor, atau pasien.
 *
 * @property int    $id
 * @property string $name              Nama pengguna
 * @property string $email             Alamat email
 * @property string $password          Password (terenkripsi)
 * @property int    $role_id           ID peran pengguna
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Atribut yang disembunyikan dari serialisasi (JSON, array).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @var array<array-key, mixed>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke model Role.
     *
     * Setiap pengguna memiliki satu peran (role).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi ke model Pendonor.
     *
     * Seorang pengguna dengan peran pendonor memiliki satu profil pendonor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pendonor()
    {
        return $this->hasOne(Pendonor::class);
    }

    /**
     * Relasi ke model Pasien.
     *
     * Seorang pengguna dengan peran pasien memiliki satu profil pasien.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pasien()
    {
        return $this->hasOne(Pasien::class);
    }
}
