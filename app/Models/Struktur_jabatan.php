<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struktur_jabatan extends Model
{
    protected $fillable = [
        'id', 'kode_jabatan', 'nama_jabatan', 'kode_atasan', 'eselon', 'level_kompetensi', 'perangkat_daerah', 'unit_kerja', 'created_at', 'updated_at',
    ];
}
