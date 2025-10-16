<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfil extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'admin_profiles';
    protected $fillable = ['user_id', 'nip', 'jabatan'];
}
