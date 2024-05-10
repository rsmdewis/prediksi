<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatans';

    protected $fillable = [
        'kd_kecamatan',
        'nm_kecamatan',
    ];

    // Definisikan relasi dengan model Data
    public function data()
    {
        return $this->hasMany(Data::class, 'kd_kecamatan', 'kd_kecamatan');
    }
}
