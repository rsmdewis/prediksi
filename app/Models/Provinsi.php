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
    ];

    // Definisikan relasi dengan model Data
    public function data()
    {
        return $this->hasMany(Data::class, 'kd_provinsi', 'kd_provinsi');
    }
}
