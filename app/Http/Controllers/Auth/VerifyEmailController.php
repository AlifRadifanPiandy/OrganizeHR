<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pjperusahaan;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $pjperusahaan = Pjperusahaan::find($request->route('id'));

        if ($pjperusahaan->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }

        if ($pjperusahaan->markEmailAsVerified()) {
            event(new Verified($pjperusahaan));
        }

        return [
            'message' => 'Email has been verified'
        ];
    }

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already Verified'
            ];
        }

        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }
}
