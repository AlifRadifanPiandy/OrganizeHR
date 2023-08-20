<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'role_admin' => $this->role_admin,
            'tipe_admin' => $this->adminrole->role_name,
            'id_role' => $this->id_role,
            'nama_role' => $this->role->role_name,
        ];
    }
}
