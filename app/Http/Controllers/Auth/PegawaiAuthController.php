<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PegawaiAuthController extends Controller
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

        $pegawai = Pegawai::where('email', $validatedData['email'])->first();

        if (!$pegawai || !Hash::check($validatedData['password'], $pegawai->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ]);
        }

        $token = $pegawai->createToken('authToken')->plainTextToken;

        Auth::guard('pegawai')->login($pegawai);

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully.',
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->user()->tokens()->delete();
        }

        return response()->json([
            "message" => "User logged out successfully."
        ], 200);
    }
}
