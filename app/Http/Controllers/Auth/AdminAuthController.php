<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'data' => $validatedData->errors()
            ], 400);
        }

        $validatedData = $validatedData->validated();

        $admin = Admin::where('email', $validatedData['email'])->first();

        if (!$admin || !Hash::check($validatedData['password'], $admin->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ]);
        }

        $token = $admin->createToken('authToken')->plainTextToken;

        Auth::guard('admin')->login($admin);

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully.',
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->user()->tokens()->delete();
        }

        return response()->json([
            "message" => "User logged out successfully."
        ], 200);
    }
}
