<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek: Sudah login belum? Dan apakah rolenya 'admin'?
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request); // Boleh lewat
        }

        // Kalau bukan admin, tendang ke katalog
        return redirect('/katalog')->with('error', 'Akses Ditolak! Lu bukan Admin ZeETOUR.');
    }
}