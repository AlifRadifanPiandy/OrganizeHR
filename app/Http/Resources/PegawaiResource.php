<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
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
            'nama_karyawan' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_lahir' => $this->tanggal_lahir,
            'status_kawin' => $this->status_kawin,
            'tempat_lahir' => $this->tempat_lahir,
            'agama' => $this->agama,
            'telepon' => $this->telepon,
            'telepon_lain' => $this->telepon_lain,
            'alamat' => $this->alamat,
            'email' => $this->email,
            'password' => $this->password,
            'email_perusahaan' => $this->email_perusahaan,
            'nik' => $this->nik,
            'no_bpjs_tk' => $this->no_bpjs_tk,
            'no_kk' => $this->no_kk,
            'no_bpjs_k' => $this->no_bpjs_k,
            'npwp' => $this->npwp,
            'nama_bank' => $this->nama_bank,
            'nama_pemilik_rekening' => $this->nama_pemilik_rekening,
            'nama_cabang_bank' => $this->nama_cabang_bank,
            'no_rekening' => $this->no_rekening,
            'tipe_karyawan' => $this->tipe_karyawan,
            'periode_mulai' => $this->periode_mulai,
            'periode_akhir' => $this->periode_akhir,
            'tanggal_rekrut' => $this->tanggal_rekrut,
            'status_aktif' => $this->status_aktif,
            'id_karyawan' => $this->id_karyawan,
            'tanggal_efektif' => $this->tanggal_efektif,
            'id_jabatan' => $this->id_jabatan,
            'jabatan' => $this->jabatan->nama,
            'id_departemen' => $this->id_departemen,
            'departemen' => $this->departemen->nama,
            'id_perusahaan' => $this->id_perusahaan,
            'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
            'id_role' => $this->id_role,
            'role' => $this->role->role_name,
        ];
    }
}
