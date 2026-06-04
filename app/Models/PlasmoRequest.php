<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlasmoRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'plasmo_id',
        'hospital_id',
        'status',
        'notes',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function plasmo()
    {
        return $this->belongsTo(Plasmo::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
