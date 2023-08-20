<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KursusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sampul' => $this->sampul,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kategori_kursus' => $this->kategorikursus->nama
        ];
    }
}
