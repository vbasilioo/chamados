<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @param  string  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        // For users with multiple permissions
        if (strpos($permission, '|') !== false) {
            $permissions = explode('|', $permission);
            foreach ($permissions as $permission) {
                if ($authGuard->user()->hasPermissionTo(trim($permission))) {
                    return $next($request);
                }
            }
            throw UnauthorizedException::forPermissions($permissions);
        }

        // For a single permission
        if (! empty($permission) && ! $authGuard->user()->hasPermissionTo($permission)) {
            throw UnauthorizedException::forPermissions([$permission]);
        }

        return $next($request);
    }
} 