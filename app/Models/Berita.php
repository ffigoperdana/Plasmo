<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Berita
 *
 * Merepresentasikan data berita atau artikel
 * yang ditampilkan dalam aplikasi donor plasma Plasmo.
 *
 * @property int    $id
 * @property string $title    Judul berita
 * @property string $content  Isi konten berita
 * @property string|null $image  Path gambar berita
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Berita extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}
