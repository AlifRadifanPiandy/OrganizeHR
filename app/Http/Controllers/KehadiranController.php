<?php

namespace App\Http\Controllers;

use App\Http\Resources\KehadiranDetailResource;
use App\Http\Resources\KehadiranResource;
use App\Http\Resources\PengumumanResource;
use App\Models\Kehadiran;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kehadiran = Kehadiran::with('pegawai:id,nama', 'perusahaan:id,nama_perusahaan')->where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kehadiran',
            'data' => KehadiranResource::collection($kehadiran)
        ], 200);
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kehadiran = Kehadiran::with('pegawai:id,nama,id_jabatan,telepon,email')->where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if($kehadiran) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data kehadiran',
                'data' => new KehadiranDetailResource($kehadiran),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data kehadiran tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    public function delete($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kehadiran = Kehadiran::where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if($kehadiran) {
            $kehadiran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data kehadiran',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data kehadiran tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}
