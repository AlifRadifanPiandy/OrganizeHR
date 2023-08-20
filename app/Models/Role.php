<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'role_name'
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'id_role', 'id');
    }

    public function pjperusahaans()
    {
        return $this->hasMany(Pjperusahaan::class, 'id_role', 'id');
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'id_role', 'id');
    }
}
