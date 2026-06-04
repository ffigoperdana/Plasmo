<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Role
 *
 * Merepresentasikan peran pengguna (role) dalam aplikasi Plasmo.
 * Peran yang tersedia: admin, pendonor, pasien.
 *
 * @property int    $id
 * @property string $name  Nama peran (admin | pendonor | pasien)
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Role extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi ke model User.
     *
     * Satu peran (role) dapat dimiliki oleh banyak pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
