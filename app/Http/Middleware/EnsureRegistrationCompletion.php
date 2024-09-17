<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureRegistrationCompletion
{
    public function handle(Request $request, Closure $next)
    {
        // Bypass middleware for routes where authentication is not expected
        if ($request->routeIs(['filament.user.auth.login', 'filament.user.auth.register', 'filament.user.auth.logout'])) {
            return $next($request);
        }

        // If the user is not authenticated, redirect them to the login page
        if (!Auth::check()) {
            return redirect()->route('filament.user.auth.login');
        }

        $user = Auth::user();

        // Bypass middleware for the email verification routes
        if ($request->routeIs(['filament.user.auth.email-verification.verify', 'filament.user.auth.email-verification.prompt'])) {
            return $next($request);
        }

        // If the user's email has not been verified, redirect them to email verification notice
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('filament.user.auth.email-verification.prompt')
                ->withErrors('You must verify your email address.');
        }

        // If the user has not completed the registration process, redirect them to choose-exam
        if (!$user->isRegistrationComplete()) {
            if (!$request->routeIs(['choose-exam', 'subjects.page', 'courses.page'])) {
                return redirect()->route('choose-exam')
                    ->with('warning', 'Please complete your registration to access this page.');
            }
        }

        return $next($request);
    }
}
