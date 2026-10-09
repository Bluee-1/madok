<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan pengguna sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // 2. Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}