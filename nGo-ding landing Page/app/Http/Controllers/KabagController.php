<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Angsuran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KabagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $anggotaData = Anggota::where('status', 'Aktif')->get();
    $countLakiLaki = $anggotaData->where('jenis_kelamin', 'Laki-Laki')->where('status', 'Aktif')->count();
    $countPerempuan = $anggotaData->where('jenis_kelamin', 'Perempuan')->where('status', 'Aktif')->count();


    $years = Simpanan::distinct()->pluck('tahun');
    $countSimpanan = [];

    foreach ($years as $year) {
        $countSimpanan[$year] = Simpanan::where('tahun', $year)->sum('jumlah');
    }

    return view('kabag.dashboard', compact('countLakiLaki', 'countPerempuan', 'years', 'countSimpanan'));
}
public function showAngsuran($id)
{
    $angsuran = Angsuran::where('id_pinjaman',$id)->get();

// Logika lainnya untuk menampilkan detail pinjaman
return view('kabag.detail_angsuran', compact('angsuran'));

}
public function status_prib()
{
    $userId = auth()->guard('anggota')->user()->no_anggota;

    $pinjaman = Pinjaman::where('no_anggota', $userId)->get();

    return view('kabag.status', ['pinjaman' => $pinjaman]);
}
public function showdetailprib($id)
{
    // Retrieve the anggota data based on the provided no_anggota
    $anggota = Anggota::where('no_anggota', $id)->first();

    if ($anggota) {
        return view('kabag/detail_pribadi', compact('anggota'));
    } else {
        // Handle the case when the anggota is not found
        return redirect()->back()->with('error', 'Anggota not found.');
    }
}
public function biasa()
{
    $no_anggota = Auth::guard('anggota')->user()->no_anggota;
    $anggotaData = Anggota::where('no_anggota', $no_anggota)->get();
    return view('kabag.PeminjamanBiasa', ['anggotaData' => $anggotaData]);
}

public function khusus()
{
    $no_anggota = Auth::guard('anggota')->user()->no_anggota;
    $anggotaData = Anggota::where('no_anggota', $no_anggota)->get();
    return view('kabag.PeminjamanKhusus', ['anggotaData' => $anggotaData]);
}

public function urgent()
{
    $no_anggota = Auth::guard('anggota')->user()->no_anggota;
    $anggotaData = Anggota::where('no_anggota', $no_anggota)->get();
    return view('kabag.PeminjamanUrgent', ['anggotaData' => $anggotaData]);
}
public function showshimpananprib($id)
{
    // Retrieve member data from the database
    $data = Anggota::join('simpanan', 'anggota.no_anggota', '=', 'simpanan.no_anggota')
        ->where('anggota.no_anggota', $id)
        ->groupBy('anggota.no_anggota', 'anggota.nama_lengkap', 'anggota.status')
        ->select('anggota.no_anggota', 'anggota.nama_lengkap', 'anggota.status', \DB::raw('SUM(simpanan.jumlah) as total_simpanan'))
        ->first();

    if ($data) {
        // Retrieve monthly savings data from the database
        $monthlySavings = Simpanan::where('no_anggota', $id)->get();

        return view('kabag/detail_simp_prib', compact('data', 'monthlySavings'));
    }

    return redirect()->back()->with('error', 'Member not found.');
}

public function data_pribadi()
{
    if (auth()->guard('anggota')->check()) {
        $userNoAnggota = auth()->guard('anggota')->user()->no_anggota;

        $anggotaData = DB::select("
            SELECT anggota.no_anggota, anggota.nama_lengkap, anggota.status, SUM(simpanan.jumlah) AS total_simpanan
            FROM anggota
            LEFT JOIN simpanan ON anggota.no_anggota = simpanan.no_anggota
            WHERE anggota.no_anggota = '" . $userNoAnggota . "'
            GROUP BY anggota.no_anggota
        ");

        return view('/kabag/data_pribadi', ['anggotaData' => $anggotaData]);
    }

    // Handle the case when the user is not authenticated
    return redirect('/sesi.login');
}

    /**
     * Show the form for creating a new resource.
     */
    public function validasiPeminjamanBiasa($id)
    {
        $peminjaman = Pinjaman::findOrFail($id);

        if (request('action') === 'sedang_menunggu_validasi_bendahara') {
            // Lakukan validasi dan perbarui status menjadi "Disetujui"
            $peminjaman->status = 'sedang_menunggu_validasi_bendahara';
            $peminjaman->save();
        } elseif (request('action') === 'tolak') {
            // Lakukan validasi dan perbarui status menjadi "Ditolak"
            $peminjaman->status = 'tolak';
            $peminjaman->save();
        }

        return redirect()->back()->with('success', 'Pengajuan berhasil divalidasi.');
    }

    public function show($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

    // Logika lainnya untuk menampilkan detail pinjaman

    return view('kabag.detail_PeminjamanBiasa', compact('pinjaman'));

    }

public function ketuapinjam(Request $request)
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
    return redirect()->route('kabag.status')->with('success', 'Peminjaman Berhasil diajukan.');
}
}

