<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)
            ->whereNotNull('nama_perusahaan')
            ->whereNotNull('kota')
            ->whereNotNull('kode_referral')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data perusahaan',
            'data' => $perusahaan
        ], 200);
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nama_perusahaan' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'email' => 'nullable|string',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kota' => 'nullable|string',
            'industri' => 'nullable|string',
            'tanggal_gabung' => 'nullable|date',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jumlah_karyawan' => 'nullable|integer',
            'npwp_perusahaan' => 'nullable|string',
            'tanggal_kena_pajak' => 'nullable|date',
            'nama_penanggung_pajak' => 'nullable|string',
            'npwp_penanggung_pajak' => 'nullable|string',
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

        if (isset($validatedData['logo_perusahaan']) && $perusahaan->logo_perusahaan) {
            $oldImagePath = public_path('assets/img/') . $perusahaan->logo_perusahaan;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        if (request()->hasFile('logo_perusahaan')) {
            $file = request()->file('logo_perusahaan');
            $filename = time() . '_' . "imglogoperusahaan." . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $validatedData['logo_perusahaan'] = $filename;
        }

        $perusahaan->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengubah data perusahaan',
            'data' => $perusahaan,
        ], 201);
    }
}
