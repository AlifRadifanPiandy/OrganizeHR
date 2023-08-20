<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaans';

    protected $fillable = [
        'nama_perusahaan',
        'no_telepon',
        'email',
        'alamat',
        'provinsi',
        'kota',
        'industri',
        'tanggal_gabung',
        'logo_perusahaan',
        'jumlah_karyawan',
        'npwp_perusahaan',
        'tanggal_kena_pajak',
        'nama_penanggung_pajak',
        'npwp_penanggung_pajak',
        'kode_referral',
        'id_pj_perusahaan',
        'status_perusahaan',
    ];

    public function pjperusahaan()
    {
        return $this->belongsTo(PjPerusahaan::class, 'id_pj_perusahaan', 'id');
    }

    public function departemens()
    {
        return $this->hasMany(Departemen::class, 'id_perusahaan', 'id');
    }

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class, 'id_perusahaan', 'id');
    }

    public function kategorikursuss()
    {
        return $this->hasMany(KategoriKursus::class, 'id_perusahaan', 'id');
    }

    public function kursuss()
    {
        return $this->hasMany(Kursus::class, 'id_perusahaan', 'id');
    }

    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'id_perusahaan', 'id');
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class, 'id_perusahaan', 'id');
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'id_perusahaan', 'id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'id_perusahaan', 'id');
    }
}
