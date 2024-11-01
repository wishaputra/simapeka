<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $table = 'kompetensi'; // Ensure the table name is correct

    protected $fillable = [
        'nip',
        'level_kompetensi',
        'integritas',
        'kerja_sama',
        'komunikasi',
        'orientasi_pada_hasil',
        'pelayanan_publik',
        'pengembangan_diri_dan_orang_lain',
        'mengelola_perubahan',
        'pengambilan_keputusan',
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
