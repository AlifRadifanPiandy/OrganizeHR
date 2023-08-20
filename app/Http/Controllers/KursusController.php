<?php

namespace App\Http\Controllers;

use App\Http\Resources\KursusDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\KursusResource;
use App\Models\Kursus;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Validator;

class KursusController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kursus = Kursus::with('kategorikursus')->where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kursus',
            'data' => KursusResource::collection($kursus)
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'sampul' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'link' => 'required|string',
            'id_kategori' => 'required|exists:kategorikursuss,id',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        if (request()->hasFile('sampul')) {
            $file = request()->file('sampul');
            $filename = time() . '_' . "imgsampulkursus." . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $validatedData['sampul'] = $filename;
        }

        $kursus = Kursus::create([
            'sampul' => $validatedData['sampul'],
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'link' => $validatedData['link'],
            'id_perusahaan' => $perusahaan->id,
            'id_kategori' => $validatedData['id_kategori'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan kursus',
            'data' => $kursus
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'link' => 'nullable|string',
            'id_kategori' => 'nullable|exists:kategorikursuss,id',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kursus = Kursus::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kursus dengan id ' . $id . ' tidak ditemukan'
            ], 404);
        }

        if (isset($validatedData['sampul']) && $kursus->sampul) {
            $oldImagePath = public_path('assets/img/') . $kursus->sampul;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        if (request()->hasFile('sampul')) {
            $file = request()->file('sampul');
            $filename = time() . '_' . "imgsampulkursus." . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $validatedData['sampul'] = $filename;
        }

        $kursus->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah kursus',
            'data' => $kursus
        ]);
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kursus = Kursus::with('kategorikursus')->where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kursus dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data kursus',
            'data' => new KursusDetailResource($kursus)
        ]);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $kursus = Kursus::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$kursus) {
            return response()->json([
                'success' => false,
                'message' => 'Data kursus dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $kursus->delete();

        if ($kursus) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data kursus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data kursus',
            ], 500);
        }
    }
}
