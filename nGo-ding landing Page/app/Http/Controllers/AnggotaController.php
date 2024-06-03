<?php namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\CalonAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller {
    public function index()
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

        return view('/anggota/dashboard', ['anggotaData' => $anggotaData]);
    }

    // Handle the case when the user is not authenticated
    return redirect('/sesi.login');
}

public function showDetailAnggota($id)
{
    // Retrieve the anggota data based on the provided no_anggota
    $anggota = Anggota::where('no_anggota', $id)->first();

    if ($anggota) {
        return view('anggota/detail_anggota', compact('anggota'));
    } else {
        // Handle the case when the anggota is not found
        return redirect()->back()->with('error', 'Anggota not found.');
    }
}



public function detailSimpanan($id)
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

    return view('anggota/detail_simpanan', compact('data', 'monthlySavings'));
}

return redirect()->back()->with('error', 'Member not found.');
}

    public function dataCalon(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $candidates = CalonAnggota::where('nama_lengkap', $search)->get();
        } else {
            $candidates = CalonAnggota::all();
        }

        return view('/ketua/calon_anggota', ['candidates' => $candidates]);
    }

    public function showDetailCalon($id)
    {
        $data = CalonAnggota::findOrFail($id);

        return view('/ketua/detail_calon', compact('data'));
    }

}
