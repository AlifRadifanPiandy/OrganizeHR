<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pjperusahaan extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'pjperusahaan';

    protected $table = 'pjperusahaans';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'nama_perusahaan',
        'kota',
        'nama_jabatan',
        'password',
        'kode_referral',
        'id_role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function perusahaans()
    {
        return $this->hasMany(Perusahaan::class, 'id_pj_perusahaan', 'id');
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class, 'id_pj_perusahaan', 'id');
    }
}
