<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('api_token') || !session('admin_user')) {
            return redirect()->route('admin.login')->with('error', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
        }

        return $next($request);
    }
}
