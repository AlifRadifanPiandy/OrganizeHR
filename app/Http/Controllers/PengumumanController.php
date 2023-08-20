<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pengumuman = Pengumuman::with('pjperusahaan:id,nama', 'perusahaan:id,nama_perusahaan')->where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pengumuman',
            'data' => PengumumanResource::collection($pengumuman)
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'judul' => 'required',
            'pengumuman' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pengumuman',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pjperusahaan = Auth::user();

        $pengumuman = Pengumuman::with('pjperusahaan:id,nama', 'perusahaan:id,nama_perusahaan')->create([
            'judul' => $validatedData['judul'],
            'pengumuman' => $validatedData['pengumuman'],
            'id_perusahaan' => $perusahaan->id,
            'id_pj_perusahaan' => $pjperusahaan->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan pengumuman',
            'data' => new PengumumanResource($pengumuman)
        ], 201);
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pengumuman = Pengumuman::with('pjperusahaan:id,nama', 'perusahaan:id,nama_perusahaan')
            ->where('id_perusahaan', $perusahaan->id)
            ->find($id);

        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengumuman dengan id ' . $id . ' tidak ditemukan',
                'data' => ''
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pengumuman',
            'data' => new PengumumanResource($pengumuman)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'judul' => 'nullable|string',
            'pengumuman' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah pengumuman',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pengumuman = Pengumuman::with('pjperusahaan:id,nama', 'perusahaan:id,nama_perusahaan')
            ->where('id_perusahaan', $perusahaan->id)
            ->where('id', $id)
            ->first();

        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengumuman dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $pengumuman->update($validatedData);

        if ($pengumuman) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data pengumuman',
                'data' => new PengumumanResource($pengumuman)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data pengumuman',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pengumuman = Pengumuman::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengumuman dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $pengumuman->delete();

        if ($pengumuman) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data pengumuman',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pengumuman',
            ], 500);
        }
    }
}
