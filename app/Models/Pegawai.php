<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'pegawai';

    protected $table = 'pegawais';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'status_kawin',
        'tempat_lahir',
        'agama',
        'telepon',
        'telepon_lain',
        'alamat',
        'email',
        'password',
        'email_perusahaan',
        'nik',
        'no_bpjs_tk',
        'no_kk',
        'no_bpjs_k',
        'npwp',
        'nama_bank',
        'nama_pemilik_rekening',
        'nama_cabang_bank',
        'no_rekening',
        'tipe_karyawan',
        'periode_mulai',
        'periode_akhir',
        'tanggal_rekrut',
        'status_aktif',
        'id_karyawan',
        'tanggal_efektif',
        'id_jabatan',
        'id_departemen',
        'id_perusahaan',
        'id_role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'id_pegawai', 'id');
    }
}
