<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = ['nama_kategori'];
    public $timestamps = false; // karena di migration tidak ada timestamps

    public function publikasi()
    {
        return $this->hasMany(Publikasi::class, 'kategori_id');
    }
}
