<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationCompletion
{
    // filament.user.auth.email-verification.prompt
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        // Bypass middleware for routes where authentication is not expected
        if ($request->routeIs('filament.user.auth.login') || $request->routeIs('filament.user.auth.register')) {
            return $next($request);
        }
        $user = Auth::user();

        // Bypass middleware for the email verification route
        if ($request->routeIs('filament.user.auth.email-verification.verify')) {
            return $next($request);
        }

        // If the user is not authenticated, redirect them to the login page
        if (!Auth::check()) {
            return redirect()->route('filament.user.auth.login');
        }

        // Check if the current route is the email verification prompt
        if ($request->routeIs('filament.user.auth.email-verification.prompt')) {
            // If it is, simply continue with the request
            return $next($request);
        }

        // If the user's email has not been verified, redirect them to email verification notice
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('filament.user.auth.email-verification.prompt')
                ->withErrors('You must verify your email address.');
        }

        // If the user has not completed the registration process, redirect them to choose-exam
        if (!$user->isRegistrationComplete()) {
            if (!$request->routeIs(['choose-exam', 'subjects.page', 'filament.user.auth.logout'])) {
                return redirect()->route('choose-exam')
                    ->with('warning', 'Please complete your registration to access this page.');
            }
        }

        return $next($request);
    }


    
}
