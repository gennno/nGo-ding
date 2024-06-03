<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanBiasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $userId = auth()->guard('anggota')->user()->no_anggota;

    $pinjaman = Pinjaman::where('no_anggota', $userId)->get();

    return view('anggota.status', ['pinjaman' => $pinjaman]);
}
public function index_ketua()
{
    $pinjaman = Pinjaman::all();
    return view('ketua.status_biasa', ['pinjaman' => $pinjaman]);
}



public function index_pengawas()
{
    $pinjaman = Pinjaman::all();
    return view('pengawas.status_biasa', ['pinjaman' => $pinjaman]);
}

public function index_bendahara()
{
    $pinjaman = Pinjaman::all();
    return view('bendahara.status_biasa', ['pinjaman' => $pinjaman]);
}
public function index_kabag()
{
    $pinjaman = Pinjaman::all();
    return view('kabag.status_biasa', ['pinjaman' => $pinjaman]);
}
public function index_sdm()
{
    $pinjaman = Pinjaman::all();
    return view('sdm.status_biasa', ['pinjaman' => $pinjaman]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.PeminjamanBiasa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'no_anggota' => 'required',
            'nama' => 'required',
            'besar_pinjaman' => 'required',
            'bunga' => 'required',
        ]);

        // Calculate jumlah_pinjaman based on besar_pinjaman and bunga
        $besar_pinjaman = $validatedData['besar_pinjaman'];
        $bunga = $validatedData['bunga'];
        $jumlah_pinjaman = $besar_pinjaman + ($besar_pinjaman * $bunga / 100);

        // Calculate total_pinjaman based on jumlah_pinjaman
        $total_pinjaman = $jumlah_pinjaman;

        // Create a new pinjaman record
        $pinjaman = new Pinjaman;
        $pinjaman->no_anggota = $validatedData['no_anggota'];
        $pinjaman->nama = $validatedData['nama'];
        $pinjaman->bagian = $request->input('bagian');
        $pinjaman->alamat = $request->input('alamat');
        $pinjaman->no_telp = $request->input('no_telp');
        $pinjaman->pekerjaan = $request->input('pekerjaan');
        $pinjaman->besar_pinjaman = $besar_pinjaman;
        $pinjaman->besar_angsuran = $request->input('besar_angsuran');
        $pinjaman->tanggal_pengajuan = Carbon::now()->toDateTimeString(); // Set tanggal_gabung as current date and time
        $pinjaman->nomor_rekening = $request->input('nomor_rekening');
        $pinjaman->email = $request->input('email');
        $pinjaman->bunga = $bunga;
        $pinjaman->total_pinjaman = $total_pinjaman;
        $pinjaman->alasan_pinjaman = $request->input('alasan_pinjaman');
        $jenis_pinjaman = $request->input('jenis_pinjaman');

        if ($jenis_pinjaman === 'biasa') {
            $pinjaman->status_pinjaman = 'validasi pengawas';
        } elseif ($jenis_pinjaman === 'urgent') {
            $pinjaman->status_pinjaman = 'validasi bendahara';
        } elseif ($jenis_pinjaman === 'khusus') {
            $pinjaman->status_pinjaman = 'validasi kabag';
        } else {
            $pinjaman->status_pinjaman = 'validasi kabag'; // Default status if jenis_pinjaman doesn't match any specific condition
        }

        $pinjaman->jenis_pinjaman = $jenis_pinjaman;
        // Set other attributes as needed
        // ...

        // Save the pinjaman record
        $pinjaman->save();

        // Return a response
        return redirect()->route('anggota.status')->with('success', 'Peminjaman Berhasil diajukan.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

    // Logika lainnya untuk menampilkan detail pinjaman

    return view('ketua.detail_PeminjamanBiasa', compact('pinjaman'));

    }
    public function showanggota($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

    // Logika lainnya untuk menampilkan detail pinjaman

    return view('anggota.detail_PeminjamanBiasa', compact('pinjaman'));

    }
    public function showDetailCalon($id)
    {
        $data = Anggota::findOrFail($id);

        return view('/ketua/detail_calon', compact('data'));
    }

    public function showAngsuran($id)
    {
        $angsuran = Angsuran::where('id_pinjaman',$id)->get();

    // Logika lainnya untuk menampilkan detail pinjaman
    return view('anggota.detail_angsuran', compact('angsuran'));

    }
}
