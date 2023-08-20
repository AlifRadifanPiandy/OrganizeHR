<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Pjperusahaan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'telepon' => 'required|string',
            'nama_perusahaan' => 'required|string',
            'kota' => 'required|string',
            'nama_jabatan' => 'required|string',
            'email' => 'required|string|email|unique:pjperusahaans',
            'password' => 'required|string|confirmed',
            'kode_referral' => 'required|string',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $pjperusahaan = Pjperusahaan::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'nama_perusahaan' => $request->nama_perusahaan,
            'kota' => $request->kota,
            'nama_jabatan' => $request->nama_jabatan,
            'email' => $request->email,
            'password' => $validatedData['password'],
            'kode_referral' => $request->kode_referral,
            'id_role' => 2
        ]);

        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'kota' => $request->kota,
            'kode_referral' => $request->kode_referral,
            'id_pj_perusahaan' => $pjperusahaan->id
        ]);

        event(new Registered($pjperusahaan));

        Auth::guard('pjperusahaan')->login($pjperusahaan);

        $pjperusahaan = Auth::guard('pjperusahaan')->user();

        $token = $pjperusahaan->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully, please check your email for verification.',
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('pjperusahaan')->attempt($validatedData)) {
            $pjperusahaan = Auth::guard('pjperusahaan')->user();
            $token = $pjperusahaan->createToken('authToken')->plainTextToken;
            return response()->json([
                'message' => 'User logged in successfully.',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('pjperusahaan')->check()) {
            Auth::guard('pjperusahaan')->user()->tokens()->delete();
        }

        return response()->json([
            "message" => "User logged out successfully."
        ], 200);
    }
}
