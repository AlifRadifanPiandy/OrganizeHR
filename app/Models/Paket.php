<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';

    protected $fillable = [
        'nama_paket',
        'waktu',
        'harga',
        'status'
    ];

    public function fiturs()
    {
        return $this->hasMany(Fitur::class, 'id_paket', 'id');
    }
}
