<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function biasa()
    {
        $no_anggota = Auth::guard('anggota')->user()->no_anggota;
        $data = Anggota::findOrFail($no_anggota);
        return view('anggota.PeminjamanBiasa', compact('data'));
    }

    public function khusus()
    {
        $no_anggota = Auth::guard('anggota')->user()->no_anggota;
        $anggotaData = Anggota::where('no_anggota', $no_anggota)->get();
        return view('anggota.PeminjamanKhusus', ['anggotaData' => $anggotaData]);
    }

    public function urgent()
    {
        $no_anggota = Auth::guard('anggota')->user()->no_anggota;
        $anggotaData = Anggota::where('no_anggota', $no_anggota)->get();
        return view('anggota.PeminjamanUrgent', ['anggotaData' => $anggotaData]);
    }
}
