<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitur extends Model
{
    use HasFactory;

    protected $table = 'fiturs';

    protected $fillable = [
        'id_paket',
        'nama_fitur',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id');
    }
}
