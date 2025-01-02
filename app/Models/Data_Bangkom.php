<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data_Bangkom extends Model
{

    use SoftDeletes;

    protected $table = 'daftar_diklat';

    protected $fillable = [
        'nama_diklat',
        'unit_kerja',
        'uptd',
        'tahun',
    ];

    protected $dates = ['deleted_at']; // For soft delete tracking

    // Define the relationship with the Perangkat_daerah model
    public function perangkatdaerah()
    {
        return $this->belongsTo(Perangkat_daerah::class, 'id_perangkat_daerahs');
    }

    // Define the relationship with the UPTD model

}
