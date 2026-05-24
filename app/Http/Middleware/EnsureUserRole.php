<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user || $user->role?->value !== $role) {
            abort(403, 'You are not allowed to access this area.');
        }

        if ($user->role === UserRole::Tenant && ! $user->is_active) {
            abort(403, 'This tenant account is inactive.');
        }

        return $next($request);
    }
}
