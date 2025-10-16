<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaProfil extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pengguna_profiles';
    protected $fillable = ['user_id', 'nip'];
}
