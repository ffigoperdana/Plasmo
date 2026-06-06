<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;

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
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @var array<array-key, mixed>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
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

    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($query) use ($term) {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        });
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
