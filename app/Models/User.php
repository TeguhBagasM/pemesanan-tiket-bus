<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'password',
        'role',
        'no_telepon',
        'jabatan',
        'owner'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function armadaAsAdmin()
    {
        return $this->hasMany(Armada::class, 'id_admin');
    }

    public function pemesananAsUser()
    {
        return $this->hasMany(Pemesanan::class, 'id_pengguna');
    }

    public function pemesananAsAdmin()
    {
        return $this->hasMany(Pemesanan::class, 'id_admin');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}