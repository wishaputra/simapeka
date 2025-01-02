<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id_role',
    'nip',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
  
  protected $primaryKey = 'nip';

    public function user_roles()
    {
        return $this->belongsTo('App\Models\User_role', 'id_role');
    }

    public function pegawai()
    {
        return $this->hasOne('App\Models\Pegawai', 'nip', 'nip');
    }

    private function getUserRole()
    {
        return $this->user_roles()->getResults();
    }

    private function checkRole($role)
    {
        $userRole = $this->getUserRole();
        return $userRole && strtolower($role) == strtolower($userRole->role);
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkRole($roles);
        }

        return false;
    }

    public function enrollments(): HasMany
  {
      return $this->hasMany(Enrollment::class, 'nip', 'nip');
  }
}