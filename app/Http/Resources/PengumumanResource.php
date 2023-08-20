<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResource extends JsonResource
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
            'judul' => $this->judul,
            'pengumuman' => $this->pengumuman,
            'pjperusahaan' => $this->pjperusahaan->nama,
            'perusahaan' => $this->perusahaan->nama_perusahaan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
