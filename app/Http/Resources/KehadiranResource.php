<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KehadiranResource extends JsonResource
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
            'id_pegawai' => $this->id_pegawai,
            'pegawai' => $this->pegawai,
            'tanggal' => $this->tanggal,
            'masuk' => $this->masuk,
            'keluar' => $this->keluar,
            'jam_kerja' => $this->masuk && $this->keluar ? $this->keluar->diffInHours($this->masuk) : null,
            'id_perusahaan' => $this->id_perusahaan,
            'perusahaan' => $this->perusahaan,
        ];
    }
}
