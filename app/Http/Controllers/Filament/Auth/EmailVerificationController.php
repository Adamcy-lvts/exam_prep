<?php

namespace App\Http\Controllers\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Http\Controllers\Auth\EmailVerificationController as BaseEmailVerificationController;
use Filament\Http\Responses\Auth\Contracts\EmailVerificationResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;

class EmailVerificationController extends BaseEmailVerificationController
{
    public function __invoke(): EmailVerificationResponse
    {
        /** @var MustVerifyEmail $user */
        $user = Filament::auth()->user();

        if ($user && !$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));

            // Instead of returning a RedirectResponse directly, you may need to use a custom response class
            // that implements the EmailVerificationResponse contract and can handle the redirection.
            return new class implements EmailVerificationResponse
            {
                public function toResponse($request)
                {
                    return redirect()->route('choose-exam');
                }
            };
        }

        // Return the original response if the user's email is already verified or no user is authenticated
        return app(EmailVerificationResponse::class);
    }
}


