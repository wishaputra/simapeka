<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Login_user extends Model
{
    protected $fillable = ['login'];

    // Set `login` as the primary key
    protected $primaryKey = 'login';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Set the primary key type to string
    protected $keyType = 'string';
}
