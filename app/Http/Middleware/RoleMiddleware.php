<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, \Closure $next, $role)
    {
        $user = Auth::user();

        // Permanent developer login (bypass everything)
        if ($user && $user->role === 'developer') {
            return $next($request);
        }

        if (!$user || $user->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
