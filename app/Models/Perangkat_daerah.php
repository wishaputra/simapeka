<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perangkat_daerah extends Model
{
    protected $fillable = [
        'id',
        'nama_perangkat_daerah',
        'created_at',
        'updated_at',
    ];
}
