<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Anggota;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'nik' => 'required',
        'nama_lengkap' => 'required',
        // Add validation rules for other form fields
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        'ttd' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        'id_card' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        'email' => 'required|email|unique:anggota,email',
    ]);

    $fotoPath = $request->file('foto')->store('img');
    $fotoKtpPath = $request->file('foto_ktp')->store('img');
    $ttdPath = $request->file('ttd')->store('img');
    $idCardPath = $request->file('id_card')->store('img');

    $data = $request->only([
        'nik',
        'nama_lengkap',
        'masa_berlaku_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_ktp',
        'kelurahan_ktp',
        'kecamatan_ktp',
        'kota_ktp',
        'kodepos_ktp',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'kodepos',
        'no_telepon_rumah',
        'no_telepon_hp',
        'status_tempat_tinggal',
        'menempati_alamat_tsb_sejak',
        'pendidikan_terakhir',
        'status_perkawinan',
        'nama_istri_suami',
        'jumlah_anak',
        'nama_ibu_kandung_pemohon',
        'npwp_pribadi',
        'nama_ahli_waris',
        'hubungan_ahli_waris',
        'no_telp_ext_kantor',
        'nip',
        'nomor_rekening',
        'bagian',
        'tgl_masuk_keperusahaan',
        'status_karyawan',
        'tanggal_gabung',
    ]);

    $data['foto'] = $fotoPath;
    $data['foto_ktp'] = $fotoKtpPath;
    $data['ttd'] = $ttdPath;
    $data['id_card'] = $idCardPath;
    $data['tanggal_daftar'] = Carbon::now()->toDateTimeString();
    $data['password'] = bcrypt($request->input('password'));
    $data['email'] = $request->input('email');
    $data['role'] = 'anggota'; // Set the default role as 'anggota'
    $data['status'] = 'Tidak Aktif'; // Set the default status as 'Tidak Aktif'


    // Assuming you have an Eloquent model called 'Anggota'
    $anggota = Anggota::create($data);

    if ($anggota) {
        return redirect('register')->with([
            'notifikasi' => 'Registrasi berhasil !',
            'type' => 'success'
        ]);
    } else {
        return redirect('register')->with([
            'notifikasi' => 'Registrasi gagal !',
            'type' => 'error'
        ]);
    }
}
}
