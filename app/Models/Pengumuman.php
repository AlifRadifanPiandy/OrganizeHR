<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'pengumuman',
        'id_pj_perusahaan',
        'id_perusahaan',
    ];

    public function pjperusahaan()
    {
        return $this->belongsTo(PjPerusahaan::class, 'id_pj_perusahaan', 'id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
}
