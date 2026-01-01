<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check which guard is being used
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            
            // For visitor routes, redirect to home page (no login page for visitors)
            return route('home');
        }
        
        return null;
    }
}
