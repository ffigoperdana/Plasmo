<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Faq
 *
 * Merepresentasikan data FAQ (Frequently Asked Questions)
 * pada aplikasi donor plasma darah Plasmo.
 *
 * @property int    $id
 * @property string $question  Pertanyaan yang sering diajukan
 * @property string $answer    Jawaban dari pertanyaan
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Faq extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'answer',
    ];
}
