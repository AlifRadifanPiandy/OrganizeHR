<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReferralResource;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
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

            $referral = Referral::with('admin')->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved referral data.',
                'data' => ReferralResource::collection($referral),
            ], 200);
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

            $referral = Referral::with('admin')->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved referral data.',
                'data' => new ReferralResource($referral),
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
                'kode_referral' => 'required|string',
                'id_admin' => 'required',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $validatedData = $validatedData->validated();

            $referral = Referral::create([
                'kode_referral' => $validatedData['kode_referral'],
                'id_admin' => $validatedData['id_admin'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Referral successfully added.',
                'data' => $referral
            ], 201);
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
                'kode_referral' => 'nullable|string',
            ]);

            if ($validatedData->fails()) {
                throw new \Exception($validatedData->errors()->first(), 400);
            }

            $validatedData = $validatedData->validated();

            $referral = Referral::find($id);

            if (!$referral) {
                throw new \Exception('Referral not found', 404);
            }

            $referral->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Referral data successfully updated.',
                'data' => $referral
            ], 200);
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

            $referral = Referral::find($id);

            if (!$referral) {
                throw new \Exception('Referral not found', 404);
            }

            $referral->delete();

            return response()->json([
                'success' => true,
                'message' => 'Referral data successfully deleted.',
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
}
