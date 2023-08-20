<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfilAdminResource;
use App\Http\Resources\PerusahaanResource;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PerusahaanAdminController extends Controller
{
    use ApiControllerTrait;

    public function index()
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $perusahaan = Perusahaan::all();

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetched company data',
                'data' => PerusahaanResource::collection($perusahaan),
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function show($id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $perusahaan = Perusahaan::find($id);

            if (!$perusahaan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetched company details',
                'data' => new PerusahaanResource($perusahaan),
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $validatedData = Validator::make($request->all(), [
                'nama_perusahaan' => 'nullable|string',
                'no_telepon' => 'nullable|string',
                'email' => 'nullable|email',
                'alamat' => 'nullable|string',
                'provinsi' => 'nullable|string',
                'kota' => 'nullable|string',
                'industri' => 'nullable|string',
                'tanggal_gabung' => 'nullable|date',
                'logo_perusahaan' => 'nullable|string',
                'jumlah_karyawan' => 'nullable|integer',
                'npwp_perusahaan' => 'nullable|string',
                'tanggal_kena_pajak' => 'nullable|date',
                'nama_penanggung_pajak' => 'nullable|string',
                'npwp_penanggung_pajak' => 'nullable|string',
                'kode_referral' => 'nullable|string',
                'id_pj_perusahaan' => 'nullable|integer',
                'status_perusahaan' => 'nullable|boolean',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $perusahaan = Perusahaan::find($id);

            if (!$perusahaan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company not found',
                ], 404);
            }

            $perusahaan->update($validatedData->validated());

            return response()->json([
                'success' => true,
                'message' => 'Successfully updated Company',
                'data' => $perusahaan
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->id_role !== 1) {
                return $this->handleForbidden();
            }

            $perusahaan = Perusahaan::find($id);

            if (!$perusahaan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company not found',
                ], 404);
            }

            $perusahaan->delete();

            return response()->json([
                'success' => true,
                'message' => 'The company was successfully deleted',
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

}
