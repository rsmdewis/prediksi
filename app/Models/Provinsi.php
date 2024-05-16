<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsis';

    protected $fillable = [
        'kd_provinsi',
        'nm_provinsi',
        'alpha',
    ];
    public function getAlphaAttribute($value)
    {
        // Format nilai alpha untuk menampilkan dua angka di belakang koma
        return number_format($value, 2);
    }
    // Definisikan relasi dengan model Data
    public function data()
    {
        return $this->hasMany(Data::class, 'kd_provinsi', 'kd_provinsi');
    }
}
