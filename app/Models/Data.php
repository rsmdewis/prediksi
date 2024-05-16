<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $table = 'data';

    protected $fillable = [
        'kd_provinsi',
        'tahun',
        'luas_panen',
        'produktivitas',
        'produksi',
    ];
    protected $casts = [
        'luas_panen' => 'decimal:2',
        'produktivitas' => 'decimal:2',
        'produksi' => 'decimal:2',
    ];
}
