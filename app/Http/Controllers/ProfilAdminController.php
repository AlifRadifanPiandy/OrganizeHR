<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfilAdminResource;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfilAdminController extends Controller
{
    use ApiControllerTrait;

    public function index()
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->role_admin !== 1) {
                return $this->handleForbidden();
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data admin',
                'data' => new ProfilAdminResource($admin)
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $admin = Auth::user();

            if (!$admin) {
                return $this->handleUnauthorized();
            }

            if ($admin->role_admin !== 1) {
                return $this->handleForbidden();
            }

            $validatedData = Validator::make($request->all(), [
                'nama' => 'required|string',
                'email' => 'required|string|email|unique:admins,email,' . Auth::user()->id,
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $admin = Admin::find(Auth::user()->id);

            if (!$admin) {
                throw new \Exception('Referral not found', 404);
            }

            $admin->update($validatedData->validated());

            return response()->json([
                'success' => true,
                'message' => 'Successfully updated admin data',
                'data' => $admin
            ]);
        } catch (\Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        if (!$admin) {
            return $this->handleUnauthorized();
        }

        if ($admin->role_admin !== 1) {
            return $this->handleForbidden();
        }

        $validatedData = Validator::make($request->all(), [
            'password_lama' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validatedData->fails()) {
            throw new \Exception($validatedData->errors()->first(), 400);
        }

        $validatedData = $validatedData->validated();

        $admin = Admin::find(Auth::user()->id);

        if (!$admin) {
            throw new \Exception('Referral not found', 404);
        }

        if (!Hash::check($validatedData['password_lama'], $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Old password does not match',
            ]);
        }

        $admin->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

}
