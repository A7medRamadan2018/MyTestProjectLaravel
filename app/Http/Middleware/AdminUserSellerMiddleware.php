<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserSellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth()->guard('admin')->user();
        $user = auth()->guard('user')->user();
        $seller = auth()->guard('seller')->user();

        if ($seller || $user || $admin)
            return $next($request);
        return response()->json(array('message' => 'please login first'));
    }
}
