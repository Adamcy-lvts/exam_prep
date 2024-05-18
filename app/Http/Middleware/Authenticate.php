<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request path starts with '/admin'
        if ($request->is('admin/*')) {
            return route('filament.admin.auth.login'); // Return the named route for admin login
        }

        // Check if the request path starts with '/user'
        if ($request->is('user/*')) {
            return route('filament.user.auth.login'); // Return the named route for user login
        }

        if ($request->is('agent/*')) {
            return route('filament.agent.auth.login'); // Return the named route for user login
        }

        // Default redirect
        return route('filament.user.auth.login');
    }
}
