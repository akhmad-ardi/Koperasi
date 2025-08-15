<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::guard('web')->check());
        if (!Auth::check()) {
            // Redirect ke halaman login dengan pesan error
            return redirect()
                ->route('login')
                ->with('msg_error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
