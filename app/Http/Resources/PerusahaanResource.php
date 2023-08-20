<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerusahaanResource extends JsonResource
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
            'nama_perusahaan' => $this->nama_perusahaan,
            'no_telepon' => $this->no_telepon,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kota' => $this->kota,
            'industri' => $this->industri,
            'tanggal_gabung' => $this->tanggal_gabung,
            'logo_perusahaan' => $this->logo_perusahaan,
            'jumlah_karyawan' => $this->jumlah_karyawan,
            'npwp_perusahaan' => $this->npwp_perusahaan,
            'tanggal_kena_pajak' => $this->tanggal_kena_pajak,
            'nama_penanggung_pajak' => $this->nama_penanggung_pajak,
            'npwp_penanggung_pajak' => $this->npwp_penanggung_pajak,
            'kode_referral' => $this->kode_referral,
            'id_pj_perusahaan' => $this->id_pj_perusahaan,
            'status_perusahaan' => $this->status_perusahaan,
        ];
    }
}
