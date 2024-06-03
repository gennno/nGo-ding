<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (Auth::guard('user')->check() && Auth::guard('user')->user()->roles == $roles) {
            return $next($request);
        } else {
            Session::flash('notifikasi', 'Anda belum login atau tidak memiliki akses!');
            Session::flash('type', 'error');
            return redirect()->route('login');
        }
    }
}
