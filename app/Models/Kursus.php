<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    protected $table = 'kursuss';

    protected $fillable = [
        'sampul',
        'judul',
        'deskripsi',
        'link',
        'id_perusahaan',
        'id_kategori'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

    public function kategorikursus()
    {
        return $this->belongsTo(KategoriKursus::class, 'id_kategori', 'id');
    }
}
