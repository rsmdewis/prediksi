<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smoothing extends Model
{
    use HasFactory;
    protected $fillable = ['kd_provinsi', 'tahun', 'produksi', 'prediksi'];

    protected $casts = [
        'produksi' => 'decimal:2',
        'prediksi' => 'decimal:2',
    ];
}
