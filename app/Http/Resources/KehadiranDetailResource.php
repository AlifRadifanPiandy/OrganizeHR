<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KehadiranDetailResource extends JsonResource
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
            'jabatan_pegawai' => $this->pegawai->jabatan,
            'total_kehadiran' => $this->kehadiran->count(),
            'rata_waktu_masuk' => $this->kehadiran->avg('masuk'),
            'rata_waktu_keluar' => $this->kehadiran->avg('keluar'),
            'tanggal' => $this->tanggal,
            'masuk' => $this->masuk,
            'keluar' => $this->keluar,
            'jam_kerja' => $this->masuk && $this->keluar ? $this->keluar->diffInHours($this->masuk) : null,
            'keterangan' => $this->kehadiran->masuk && $this->kehadiran->keluar ? 'Hadir' : 'Tidak Hadir',
        ];
    }
}
