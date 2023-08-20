<?php

namespace App\Http\Controllers;

use App\Http\Resources\EbookResource;
use App\Http\Resources\EbookDetailResource;
use App\Models\Ebook;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EBookPegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::find(Auth::user()->id);

        $perusahaan = $pegawai->id_perusahaan;

        $ebook = Ebook::where('id_perusahaan', $perusahaan)->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data ebook',
            'data' => EbookResource::collection($ebook)
        ], 200);
    }

    public function show($id)
    {
        $pegawai = Pegawai::find(Auth::user()->id);

        $perusahaan = $pegawai->id_perusahaan;

        $ebook = Ebook::where('id_perusahaan', $perusahaan)->where('id', $id)->first();

        if (!$ebook) {
            return response()->json([
                'message' => 'Data ebook tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil menampilkan data ebook',
            'data' => new EbookDetailResource($ebook)
        ]);
    }
}
