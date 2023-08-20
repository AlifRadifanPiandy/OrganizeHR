<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKursus extends Model
{
    use HasFactory;

    protected $table = 'kategorikursuss';

    protected $fillable = [
        'nama',
        'id_perusahaan',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

    public function kursuss()
    {
        return $this->hasMany(Kursus::class, 'id_kategori', 'id');
    }
}
