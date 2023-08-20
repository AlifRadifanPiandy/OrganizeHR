<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $table = 'adminroles';

    protected $fillable = [
        'role_name',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_admin', 'id');
    }
}
