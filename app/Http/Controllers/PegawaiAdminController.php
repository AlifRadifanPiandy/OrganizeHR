<?php

namespace App\Http\Controllers;

use App\Http\Resources\PegawaiResource;
use App\Http\Resources\ProfilAdminResource;
use App\Models\Pegawai;
use App\Models\Perusahaan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PegawaiAdminController extends Controller
{
    use ApiControllerTrait;

    public function index($id_perusahaan)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $pegawai = Pegawai::with('jabatan', 'departemen', 'perusahaan')->where('id_perusahaan', $id_perusahaan)->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieve employee data',
                'data' => PegawaiResource::collection($pegawai)
            ], 200);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function show($id_perusahaan, $id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $pegawai = Pegawai::with('jabatan', 'departemen', 'perusahaan')->where('id_perusahaan', $id_perusahaan)->find($id);

            if (!$pegawai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetched employee details',
                'data' => new PegawaiResource($pegawai),
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function update(Request $request, $id_perusahaan, $id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $pegawai = Pegawai::where('id_perusahaan', $id_perusahaan)->find($id);

            if (!$pegawai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found',
                ], 404);
            }

            $validatedData = Validator::make($request->all(), [
                'nama_pegawai' => 'required|string',
                'no_telepon' => 'required|string',
                'email' => 'required|email',
                'alamat' => 'nullable|string',
                'provinsi' => 'nullable|string',
                'kota' => 'nullable|string',
                'industri' => 'nullable|string',
                'tanggal_gabung' => 'nullable|date',
                'logo_pegawai' => 'nullable|string',
                'jumlah_karyawan' => 'required|integer',
                'npwp_pegawai' => 'nullable|string',
                'tanggal_kena_pajak' => 'nullable|date',
                'nama_penanggung_pajak' => 'nullable|string',
                'npwp_penanggung_pajak' => 'nullable|string',
                'kode_referral' => 'required|string',
                'id_pj_pegawai' => 'required|integer',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $pegawai->update($validatedData->validated());

            return response()->json([
                'success' => true,
                'message' => 'Successfully updated employee',
                'data' => $pegawai
            ]);

        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function destroy($id_perusahaan, $id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $pegawai = Pegawai::where('id_perusahaan', $id_perusahaan)->find($id);

            if (!$pegawai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found',
                ], 404);
            }

            $pegawai->delete();

            return response()->json([
                'success' => true,
                'message' => 'The employee was successfully deleted',
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }
}
