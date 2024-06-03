<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sesi.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('user')->attempt($credentials)) {
        $user = Auth::guard('user')->user();

        // Status check removed here.

        if ($user->roles == 'admin') {
            return redirect('/admin/dashboard')->with([
                'notifikasi' => 'Login berhasil !',
                'type' => 'success'
            ]);
        } elseif ($user->roles == 'student') {
            return redirect('/student/dashboard')->with([
                'notifikasi' => 'Login berhasil !',
                'type' => 'success'
            ]);
        } elseif ($user->roles == 'mentor') {
            return redirect('/mentor/dashboard')->with([
                'notifikasi' => 'Login berhasil !',
                'type' => 'success'
            ]);
        }

        // If the role is none of the above, you might want to handle that case as well.

    } else {
        return redirect('sesi')->with([
            'notifikasi' => 'Login gagal, E-Mail atau Password salah !',
            'type' => 'error'
        ]);
    }
}

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with([
            'notifikasi' => 'Logout berhasil !',
            'type' => 'success'
        ]);
    }

}

