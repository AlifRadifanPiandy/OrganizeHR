<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfilPegawaiResource;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::where('id', Auth::user()->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pegawai',
            'data' => new ProfilPegawaiResource($pegawai)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'telepon' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data',
                'errors' => $validatedData->errors()
            ]);
        }

        $validatedData = $validatedData->validated();

        $pegawai = Pegawai::find(Auth::user()->id);

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai tidak ditemukan'
            ], 404);
        }

        $pegawai->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data pegawai',
            'data' => $pegawai
        ]);
    }


    public function updatePassword(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'password_lama' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah password',
                'errors' => $validatedData->errors()
            ]);
        }

        $validatedData = $validatedData->validated();

        if (!Auth::user()->checkPassword($validatedData['password_lama'])) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai',
            ]);
        }

        $pegawai = Pegawai::find(Auth::user()->id);

        $pegawai->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah password',
        ]);
    }
}
