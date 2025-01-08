<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komtek extends Model
{
    protected $table = 'komtek';

    protected $fillable = [
        'nip_atasan',    // Filled when atasan checks data from diklat detail
        'nip_bawahan',   // Filled when a user fills it from the diklat mandiri panel
        'id_diklat_bawahan',  // Filled with the ID of diklat that user checks in the diklat mandiri panel
        'id_diklat_atasan',   // Filled with the ID of diklat from daftar diklat that user checks in diklat detail panel
        'creator',  // Filled with the creator's NIP
        'created_at',  // Automatically managed by Laravel
        'updated_at',  // Automatically managed by Laravel
    ];

    public function bawahanDiklat()
    {
        return $this->belongsTo(DaftarDiklat::class, 'id_diklat_bawahan');
    }

    public function atasanDiklat()
    {
        return $this->belongsTo(DaftarDiklat::class, 'id_diklat_atasan');
    }

    public function daftarDiklat()
    {
        return $this->belongsTo(Data_Bangkom::class, 'id_diklat_atasan', 'id');
    }
}
