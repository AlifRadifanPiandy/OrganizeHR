<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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

            $admin = Admin::with('role', 'adminrole')->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved Admin data.',
                'data' => AdminResource::collection($admin)
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function store(Request $request)
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
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|string|min:8',
                'role_admin' => 'required|numeric',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $validatedData = $validatedData->validated();
            $password = bcrypt($validatedData['password']);

            $admin = Admin::create([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'password' => $password,
                'role_admin' => $validatedData['role_admin'],
                'id_role' => 1,
            ]);

            if ($admin) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin successfully created.',
                    'data' => new AdminResource($admin)
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add Admin data. ',
                ], 400);
            }
        } catch (\Exception $e) {
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

            if ($admin->role_admin !== 1) {
                return $this->handleForbidden();
            }

            $adminData = Admin::with('role', 'adminrole')->find($id);

            if (!$adminData) {
                throw new \Exception('Admin not found', 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin details retrieved successfully',
                'data' => new AdminResource($adminData)
            ], 200);
        } catch (\Exception $e) {
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

            if ($admin->role_admin !== 1) {
                return $this->handleForbidden();
            }

            $validatedData = Validator::make($request->all(), [
                'nama' => 'nullable|string',
                'email' => 'nullable|email|unique:admins,email',
                'password' => 'nullable|string|min:8',
                'role_admin' => 'nullable|numeric',
                'id_role' => 'nullable|numeric',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $validatedData = $validatedData->validated();

            $admin = Admin::find($id);

            if (!$admin) {
                throw new \Exception('Admin not found', 404);
            }

            $password = bcrypt($validatedData['password']);

            $admin->update([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'password' => $password,
                'role_admin' => $validatedData['role_admin'],
                'id_role' => 1,
            ]);

            if ($admin) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin data successfully updated.',
                    'data' => new AdminResource($admin)
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update Admin data. ',
                ], 400);
            }
        } catch (\Exception $e) {
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

            if ($admin->role_admin !== 1) {
                return $this->handleForbidden();
            }

            $admin = Admin::find($id);

            if (!$admin) {
                throw new \Exception('Admin not found', 404);
            }

            $admin->delete();

            if ($admin) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin data successfully deleted.',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete Admin data. ',
                ], 400);
            }
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}
