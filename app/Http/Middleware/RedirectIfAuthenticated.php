<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        $auth = session('auth_user');

        if ($auth) {
            $role = $auth['role'] ?? 'client';

            return match ($role) {
                'admin' => redirect()->route('admin.index'),
                'employee' => redirect()->route('employee.conferences.index'),
                default => redirect()->route('client.conferences.index'),
            };
        }

        return $next($request);
    }
}