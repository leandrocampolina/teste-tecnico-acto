<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $isAdmin = false;

        if ($user) {
            if (method_exists($user, 'isAdmin')) {
                $isAdmin = $user->isAdmin();
            } elseif (isset($user->role)) {
                $isAdmin = $user->role === 'admin';
            }
        }

        if (! $isAdmin) {
            abort(403);
        }

        return $next($request);
    }
}
