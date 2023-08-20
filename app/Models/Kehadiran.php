<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadirans';

    protected $fillable = [
        'tanggal',
        'masuk',
        'keluar',
        'keterangan',
        'jam_kerja',
        'total_kehadiran',
        'rata_waktu_masuk',
        'rata_waktu_keluar',
        'id_pegawai',
        'id_perusahaan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }
}
