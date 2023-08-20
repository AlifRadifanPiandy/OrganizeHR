<?php

namespace App\Http\Controllers;

use App\Http\Resources\KursusDetailResource;
use App\Http\Resources\KursusResource;
use App\Models\Kursus;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KursusPegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::find(Auth::user()->id);

        $perusahaan = $pegawai->id_perusahaan;

        $kursus = Kursus::with('kategorikursus')->where('id_perusahaan', $perusahaan)->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data kursus',
            'data' => KursusResource::collection($kursus)
        ], 200);
    }

    public function show($id)
    {
        $pegawai = Pegawai::find(Auth::user()->id);

        $perusahaan = $pegawai->id_perusahaan;

        $kursus = Kursus::with('kategorikursus')->where('id_perusahaan', $perusahaan)->where('id', $id)->first();

        if (!$kursus) {
            return response()->json([
                'message' => 'Data kursus tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil menampilkan data kursus',
            'data' => new KursusDetailResource($kursus)
        ], 200);
    }
}
