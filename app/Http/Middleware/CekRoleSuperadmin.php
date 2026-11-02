<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRoleSuperadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('nama_role') !== 'Superadmin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Khusus Superadmin.');
        }

        return $next($request);
    }
}
