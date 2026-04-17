<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        //Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        //Cek apakah role sudah sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki role yang diperlukan');
        }
        return $next($request);
        
    }
}
