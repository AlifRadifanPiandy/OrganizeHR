<?php

namespace App\Http\Controllers;

use App\Http\Resources\KategoriKursusResource;
use App\Models\KategoriKursus;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KategoriKursusController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kategorikursus = KategoriKursus::where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kategori kursus',
            'data' => KategoriKursusResource::collection($kategorikursus)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $validatedData = $validator->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kategorikursus = KategoriKursus::create([
            'nama' => $validatedData['nama'],
            'id_perusahaan' => $perusahaan->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan kategori kursus',
            'data' => $kategorikursus
        ]);
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kategorikursus = KategoriKursus::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kategorikursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori kursus dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kategori kursus',
            'data' => new KategoriKursusResource($kategorikursus)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $validatedData = $validator->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kategorikursus = KategoriKursus::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kategorikursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori kursus dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $kategorikursus->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah kategori kursus',
            'data' => $kategorikursus
        ]);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kategorikursus = KategoriKursus::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kategorikursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori kursus dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $kategorikursus->delete();

        if ($kategorikursus) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus kategori kursus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori kursus',
            ], 500);
        }
    }
}
