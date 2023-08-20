<?php

namespace App\Http\Controllers;

use App\Http\Resources\JabatanResource;
use App\Models\Jabatan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $jabatan = Jabatan::with('perusahaan')->where('id_perusahaan', $perusahaan->id)->get();

        $jumlah_jabatan = $jabatan->count();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data jabatan',
            'data' => JabatanResource::collection($jabatan),
            'jumlah_jabatan' => $jumlah_jabatan,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validatedData->errors()->first(),
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $jabatan = Jabatan::create([
            'id_perusahaan' => $perusahaan->id,
            'nama' => $validatedData['nama'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan jabatan',
            'data' => $jabatan
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validatedData->errors()->first(),
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $jabatan = Jabatan::where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if (!$jabatan) {
            return response()->json([
                'success' => false,
                'message' => 'jabatan tidak ditemukan'
            ], 404);
        }

        $jabatan->update([
            'nama' => $validatedData['nama'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data jabatan',
            'data' => $jabatan
        ], 200);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $jabatan = Jabatan::where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if (!$jabatan) {
            return response()->json([
                'success' => false,
                'message' => 'jabatan tidak ditemukan'
            ], 404);
        }

        $jabatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data jabatan',
        ], 200);
    }
}
