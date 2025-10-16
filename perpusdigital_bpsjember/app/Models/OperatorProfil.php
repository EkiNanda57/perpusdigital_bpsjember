<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorProfil extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'operator_profiles';
    protected $fillable = ['user_id', 'nip'];
}
