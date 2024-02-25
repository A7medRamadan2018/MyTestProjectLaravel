<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdminMidlleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin || !$admin->super_admin) {
            return response()->json(['message' => 'You are Unauthorized'], 403);
        }
        return $next($request);
    }
}
