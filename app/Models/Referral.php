<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $fillable = [
        'kode_referral',
        'id_admin',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id');
    }
}
