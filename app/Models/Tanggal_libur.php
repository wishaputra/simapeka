<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggal_libur extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'tanggal_libur';

    // Fillable fields
    protected $fillable = [
        'tanggal',
        'nama',
    ];
}
