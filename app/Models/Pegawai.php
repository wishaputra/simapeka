<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'id',
        'nip',
        'nama',
        'eselon',
        'jabatan',
        'unit_kerja',
        'jabatan_tambahan',
        'uptd',
        'foto',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'nip');
    }

    public function strukturJabatan()
    {
        return $this->belongsTo('App\Struktur_jabatan', 'jabatan', 'nama_jabatan');
    }

    public function penilaian_pribadi()
    {
        return $this->hasMany('App\Penilaian_pribadi', 'nip', 'nip');
    }

    public function penilaian_atasan()
    {
        return $this->hasMany('App\Penilaian_atasan', 'nip_bawahan', 'nip');
    }

    public function kompetensi()
    {
        return $this->hasOne(Kompetensi::class, 'nip', 'nip');
    }


}
