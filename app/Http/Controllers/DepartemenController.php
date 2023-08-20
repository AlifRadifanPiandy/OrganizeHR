<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartemenResource;
use App\Models\Departemen;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $departemen = Departemen::with('perusahaan')->where('id_perusahaan', $perusahaan->id)->get();

        $jumlah_departemen = $departemen->count();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data departemen',
            'data' => DepartemenResource::collection($departemen),
            'jumlah_departemen' => $jumlah_departemen
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

        $departemen = Departemen::create([
            'id_perusahaan' => $perusahaan->id,
            'nama' => $validatedData['nama'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan departemen',
            'data' => $departemen
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

        $departemen = Departemen::where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if (!$departemen) {
            return response()->json([
                'success' => false,
                'message' => 'Departemen tidak ditemukan'
            ], 404);
        }

        $departemen->update([
            'nama' => $validatedData['nama'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data departemen',
            'data' => $departemen
        ], 200);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $departemen = Departemen::where('id_perusahaan', $perusahaan->id)->where('id', $id)->first();

        if (!$departemen) {
            return response()->json([
                'success' => false,
                'message' => 'Departemen tidak ditemukan'
            ], 404);
        }

        $departemen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data departemen',
        ], 200);
    }
}
