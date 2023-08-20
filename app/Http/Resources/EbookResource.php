<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EbookResource extends JsonResource
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
            'created_at' => $this->created_at,
            'publisher' => $this->publisher,
            'halaman' => $this->halaman,
            'bahasa' => $this->bahasa,
        ];
    }
}
