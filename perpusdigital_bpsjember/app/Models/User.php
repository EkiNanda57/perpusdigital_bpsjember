<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Kolom yang disembunyikan dari array/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Konversi tipe data otomatis
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ✅ Relasi ke tabel roles (pivot: role_user)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    // ✅ Cek apakah user punya role tertentu
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }

    // ✅ Hash password otomatis kalau diubah
    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }

        if (password_get_info($value)['algo'] === 0) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
