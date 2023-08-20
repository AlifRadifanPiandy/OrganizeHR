<?php

namespace App\Http\Controllers;

use App\Http\Resources\EbookDetailResource;
use App\Http\Resources\EbookResource;
use App\Models\Ebook;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EbookController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $ebook = Ebook::where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data ebook',
            'data' => EbookResource::collection($ebook)
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'sampul' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'publisher' => 'required|string',
            'halaman' => 'required|string',
            'bahasa' => 'required|string',
            'sinopsis' => 'required|string',
            'link' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan ebook',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        if (request()->hasFile('sampul')) {
            $file = request()->file('sampul');
            $filename = time() . '_' . "imgsampulebook." . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $validatedData['sampul'] = $filename;
        }

        $ebook = Ebook::create([
            'sampul' => $validatedData['sampul'],
            'judul' => $validatedData['judul'],
            'penulis' => $validatedData['penulis'],
            'publisher' => $validatedData['publisher'],
            'halaman' => $validatedData['halaman'],
            'bahasa' => $validatedData['bahasa'],
            'sinopsis' => $validatedData['sinopsis'],
            'link' => $validatedData['link'],
            'id_perusahaan' => $perusahaan->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan ebook',
            'data' => $ebook
        ], 201);
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $ebook = Ebook::where('id_perusahaan', $perusahaan->id)
            ->find($id);

        if (!$ebook) {
            return response()->json([
                'success' => false,
                'message' => 'Data ebook dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data ebook dengan id ' . $id,
            'data' => new EbookDetailResource($ebook)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'nullable|string',
            'penulis' => 'nullable|string',
            'publisher' => 'nullable|string',
            'halaman' => 'nullable|string',
            'bahasa' => 'nullable|string',
            'sinopsis' => 'nullable|text',
            'link' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah ebook',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $ebook = Ebook::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$ebook) {
            return response()->json([
                'success' => false,
                'message' => 'Data ebook dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        if (isset($validatedData['sampul']) && $ebook->sampul) {
            $oldImagePath = public_path('assets/img/') . $ebook->sampul;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        if (request()->hasFile('sampul')) {
            $file = request()->file('sampul');
            $filename = time() . '_' . "imgsampulebook." . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $validatedData['sampul'] = $filename;
        }

        $ebook->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah ebook',
            'data' => $ebook
        ], 200);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $ebook = Ebook::where('id_perusahaan', $perusahaan->id)->find($id);

        if (!$ebook) {
            return response()->json([
                'success' => false,
                'message' => 'Data ebook dengan id ' . $id . ' tidak ditemukan',
            ], 404);
        }

        $ebook->delete();

        if (!$ebook) {
            return response()->json([
                'success' => false,
                'message' => 'Data ebook dengan id ' . $id . ' tidak berhasil dihapus',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data ebook dengan id ' . $id . ' berhasil dihapus',
            ], 200);
        }
    }
}
