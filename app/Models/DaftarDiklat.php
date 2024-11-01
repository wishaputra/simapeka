<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarDiklat extends Model
{
    protected $table = 'daftar_diklat';

    protected $fillable = [
        'nama_diklat',
        'unit_kerja',
        'uptd',
    ];

    // Define the relationship with the Perangkat_daerah model
    public function perangkatdaerah()
    {
        return $this->belongsTo(Perangkat_daerah::class, 'id_perangkat_daerahs');
    }

}
