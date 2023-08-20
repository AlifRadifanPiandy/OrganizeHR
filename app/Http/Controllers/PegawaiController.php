<?php

namespace App\Http\Controllers;

use App\Http\Resources\PegawaiResource;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Perusahaan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pegawai = Pegawai::with('jabatan:id,nama', 'departemen:id,nama', 'perusahaan:id,nama_perusahaan', 'role:id,role_name')->where('id_perusahaan', $perusahaan->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pegawai',
            'data' => PegawaiResource::collection($pegawai)
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'status_kawin' => 'required|string',
            'tempat_lahir' => 'required|string',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'telepon' => 'required|string',
            'telepon_lain' => 'nullable|string',
            'alamat' => 'required|string',
            'email' => 'required|string|email|unique:pegawais',
            'password' => 'required|string',
            'email_perusahaan' => 'required|string|email|unique:pegawais',
            'nik' => 'required|string',
            'no_bpjs_tk' => 'required|string',
            'no_kk' => 'required|string',
            'no_bpjs_k' => 'required|string',
            'npwp' => 'required|string',
            'nama_bank' => 'required|string',
            'nama_pemilik_rekening' => 'required|string',
            'nama_cabang_bank' => 'required|string',
            'no_rekening' => 'required|string',
            'tipe_karyawan' => 'required|string',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date',
            'tanggal_rekrut' => 'required|date',
            'status_aktif' => 'required|boolean',
            'id_karyawan' => 'required|string|unique:pegawais',
            'tanggal_efektif' => 'required|date',
            'id_jabatan' => 'required',
            'id_departemen' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pegawai',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $role = Role::where('id', 3)->first();

        $password = bcrypt($validatedData['password']);

        $pegawai = Pegawai::with('jabatan:id,nama', 'departemen:id,nama', 'perusahaan:id,nama_perusahaan', 'role:id,role_name')->create([
            'nama' => $validatedData['nama'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'status_kawin' => $validatedData['status_kawin'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'agama' => $validatedData['agama'],
            'telepon' => $validatedData['telepon'],
            'telepon_lain' => $validatedData['telepon_lain'],
            'alamat' => $validatedData['alamat'],
            'email' => $validatedData['email'],
            'password' => $password,
            'email_perusahaan' => $validatedData['email_perusahaan'],
            'nik' => $validatedData['nik'],
            'no_bpjs_tk' => $validatedData['no_bpjs_tk'],
            'no_kk' => $validatedData['no_kk'],
            'no_bpjs_k' => $validatedData['no_bpjs_k'],
            'npwp' => $validatedData['npwp'],
            'nama_bank' => $validatedData['nama_bank'],
            'nama_pemilik_rekening' => $validatedData['nama_pemilik_rekening'],
            'nama_cabang_bank' => $validatedData['nama_cabang_bank'],
            'no_rekening' => $validatedData['no_rekening'],
            'tipe_karyawan' => $validatedData['tipe_karyawan'],
            'periode_mulai' => $validatedData['periode_mulai'],
            'periode_akhir' => $validatedData['periode_akhir'],
            'tanggal_rekrut' => $validatedData['tanggal_rekrut'],
            'status_aktif' => $validatedData['status_aktif'],
            'id_karyawan' => $validatedData['id_karyawan'],
            'tanggal_efektif' => $validatedData['tanggal_efektif'],
            'id_jabatan' => $validatedData['id_jabatan'],
            'id_departemen' => $validatedData['id_departemen'],
            'id_perusahaan' => $perusahaan->id,
            'id_role' => $role->id,
        ]);

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan data pegawai',
                'data' => new PegawaiResource($pegawai)
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pegawai',
            ], 400);
        }
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pegawai = Pegawai::with('jabatan:id,nama', 'departemen:id,nama', 'perusahaan:id,nama_perusahaan', 'role:id,role_name')
            ->where('id_perusahaan', $perusahaan->id)
            ->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pegawai',
            'data' => new PegawaiResource($pegawai)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'status_kawin' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'agama' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'telepon' => 'nullable|string',
            'telepon_lain' => 'nullable|string',
            'alamat' => 'nullable|string',
            'email' => 'nullable|string|email|unique:pegawais',
            'password' => 'nullable|string',
            'email_perusahaan' => 'nullable|string|email|unique:pegawais',
            'nik' => 'nullable|string',
            'no_bpjs_tk' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'no_bpjs_k' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nama_bank' => 'nullable|string',
            'nama_pemilik_rekening' => 'nullable|string',
            'nama_cabang_bank' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'tipe_karyawan' => 'nullable|string',
            'periode_mulai' => 'nullable|date',
            'periode_akhir' => 'nullable|date',
            'tanggal_rekrut' => 'nullable|date',
            'status_aktif' => 'nullable|boolean',
            'id_karyawan' => 'nullable|string|unique:pegawais',
            'tanggal_efektif' => 'nullable|date',
            'id_jabatan' => 'nullable',
            'id_departemen' => 'nullable',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data pegawai',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pegawai = Pegawai::with('jabatan:id,nama', 'departemen:id,nama', 'perusahaan:id,nama_perusahaan', 'role:id,role_name')
            ->where('id_perusahaan', $perusahaan->id)
            ->where('id', $id)
            ->first();

        $pegawai->update($validatedData);

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data pegawai',
                'data' => new PegawaiResource($pegawai)
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data pegawai',
            ], 400);
        }
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('id_pj_perusahaan', Auth::user()->id)->first();

        $pegawai = Pegawai::where('id_perusahaan', $perusahaan->id)->find($id);

        if(!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan',
            ], 404);
        }

        $pegawai->delete();

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data pegawai',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pegawai',
            ], 400);
        }
    }
}
