<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanBiasaController;
use App\Http\Controllers\PeminjamanUrgentController;
use App\Http\Controllers\PeminjamanKhususController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KabagController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\SekretarisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/FAQ', function () {
    return view('faq');
});

Route::get('/TENTANG', function () {
    return view('tentang');
});

Route::get('/PENGEMBANGAN', function () {
    return view('pengembangan');
});


// Route::get('/login', function () {
//     return view('login');
// });

// Route::get('/register', function () {
//     return view('register');
// });




#login
Route::get('/sesi',[SesiController::class,'index'])->name('login');
Route::post('/sesi/login',[SesiController::class,'login']);
Route::post('/logout',[SesiController::class,'logout']);

#Ketua
Route::middleware(['userAkses:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/ketua/data_anggota', [KetuaController::class, 'DataAnggota']);
    Route::get('/ketua/data_pribadi',[KetuaController::class,'data_pribadi'])->name('data_pribadi');
    Route::get('/ketua/detail_anggota/{id}', [KetuaController::class, 'showDetailAnggota'])->name('detail_anggota');
    Route::get('/ketua/detail_simpanan/{id}', [KetuaController::class, 'detailSimpanan'])->name('detail_simpanan');
    Route::get('/ketua/calon_anggota', [KetuaController::class, 'calon_anggota']);
    Route::get('/ketua/status_biasa', [PeminjamanBiasaController::class, 'index_ketua']);
    Route::get('/ketua/status_urgent', [PeminjamanUrgentController::class, 'index_ketua']);
    Route::get('/ketua/status_khusus', [PeminjamanKhususController::class, 'index_ketua']);
    Route::get('/ketua/calon_anggota', [KetuaController::class, 'dataCalon'])->name('calon_anggota');
    Route::get('/ketua/detail_calon/{id}', [KetuaController::class, 'showDetailCalon'])->name('detail_calon');
    Route::get('/ketua/detail/{id}', [PeminjamanBiasaController::class, 'show'])->name('ketua.detail_PeminjamanBiasa');
    Route::post('/ketua/calon_anggota', [KetuaController::class, 'store'])->name('store.calon_anggota');
    Route::get('/ketua/angsuran/{id}', [KetuaController::class, 'showangsuran'])->name('ketua.angsuran');
    Route::post('/ketua/angsuran/{id}', [KetuaController::class, 'angsuranStore'])->name('angsuran.store');
    Route::get('/ketua/formbiasa',[KetuaController::class,'biasa']);
    Route::get('/ketua/formkhusus',[KetuaController::class,'khusus']);
    Route::get('/ketua/formurgent',[KetuaController::class,'urgent']);
    Route::get('/ketua/status', [KetuaController::class, 'status_prib'])->name('ketua.status');
    Route::get('/ketua/detail_angsuran/{id}', [KetuaController::class, 'showdetailangsuran'])->name('ketua.detail_angsuran');
    Route::post('/ketua/formbiasa', [KetuaController::class, 'ketuapinjam'])->name('ketua.store');
    Route::post('/ketua/formkhusus', [KetuaController::class, 'ketuapinjam'])->name('ketua.store');
    Route::post('/ketua/formurgent', [KetuaController::class, 'ketuapinjam'])->name('ketua.store');
    Route::get('/ketua/detail_pribadi/{id}', [KetuaController::class, 'showdetailprib'])->name('detail_pribadi');
    Route::get('/ketua/detail_simp_prib/{id}', [KetuaController::class, 'showshimpananprib'])->name('simpanan_pribadi');
});

Route::middleware(['userAkses:bendahara'])->group(function () {
    Route::get('/bendahara/dashboard',[BendaharaController::class,'index']);
    Route::get('/bendahara/data_anggota',[BendaharaController::class,'DataAnggota']);
    Route::get('/bendahara/data_pribadi',[BendaharaController::class,'data_pribadi'])->name('data_pribadi_bendahara');
    Route::get('/bendahara/status_biasa', [PeminjamanBiasaController::class, 'index_bendahara']);
    Route::get('/bendahara/detail_pribadi/{id}', [BendaharaController::class, 'showdetailprib'])->name('detail_pribadi_bendahara');
    Route::get('/bendahara/detail_simp_prib/{id}', [BendaharaController::class, 'showshimpananprib'])->name('simpanan_pribadi_bendahara');
    Route::get('/bendahara/angsuran/{id}', [BendaharaController::class, 'showangsuran'])->name('bendahara.angsuran');
    Route::post('/bendahara/angsuran/{id}', [BendaharaController::class, 'angsuranStore'])->name('angsuran.store_bendahara');
    Route::get('/bendahara/detail_angsuran/{id}', [BendaharaController::class, 'showdetailangsuran'])->name('bendahara.detail_angsuran');
    Route::get('/bendahara/detail/{id}', [BendaharaController::class, 'show'])->name('bendahara.detail_PeminjamanBiasa');
    Route::get('/bendahara/detail_pribadi/{id}', [BendaharaController::class, 'showdetailprib'])->name('detail_pribadi_bendahara');
    Route::get('/bendahara/detail_simp_prib/{id}', [BendaharaController::class, 'showshimpananprib'])->name('simpanan_pribadi_bendahara');
    Route::get('/bendahara/formbiasa',[BendaharaController::class,'biasa']);
    Route::get('/bendahara/formkhusus',[BendaharaController::class,'khusus']);
    Route::get('/bendahara/formurgent',[BendaharaController::class,'urgent']);
    Route::post('/bendahara/formbiasa', [BendaharaController::class, 'ketuapinjam'])->name('bendahara.store');
    Route::post('/bendahara/formkhusus', [BendaharaController::class, 'ketuapinjam'])->name('bendahara.store');
    Route::post('/bendahara/formurgent', [BendaharaController::class, 'ketuapinjam'])->name('bendahara.store');
    Route::get('/bendahara/status', [BendaharaController::class, 'status_prib'])->name('bendahara.status');
});

Route::middleware(['userAkses:pengawas'])->group(function () {
    Route::get('/pengawas/dashboard',[PengawasController::class,'index']);
    Route::get('/pengawas/data_anggota',[PengawasController::class,'DataAnggota']);
    Route::get('/pengawas/data_pribadi',[PengawasController::class,'data_pribadi'])->name('data_pribadi_pengawas');
    Route::get('/pengawas/status_biasa', [PeminjamanBiasaController::class, 'index_pengawas']);
    Route::get('/pengawas/detail/{id}', [PengawasController::class, 'show'])->name('pengawas.detail_PeminjamanBiasa');
    Route::get('/pengawas/detail_pribadi/{id}', [PengawasController::class, 'showdetailprib'])->name('detail_pribadi_pengawas');
    Route::get('/pengawas/detail_simp_prib/{id}', [PengawasController::class, 'showshimpananprib'])->name('simpanan_pribadi_pengawas');
    Route::get('/pengawas/formbiasa',[PengawasController::class,'biasa']);
    Route::get('/pengawas/formkhusus',[PengawasController::class,'khusus']);
    Route::get('/pengawas/formurgent',[PengawasController::class,'urgent']);
    Route::post('/pengawas/formbiasa', [PengawasController::class, 'ketuapinjam'])->name('pengawas.store');
    Route::post('/pengawas/formkhusus', [PengawasController::class, 'ketuapinjam'])->name('pengawas.store');
    Route::post('/pengawas/formurgent', [PengawasController::class, 'ketuapinjam'])->name('pengawas.store');
    Route::get('/pengawas/status', [PengawasController::class, 'status_prib'])->name('pengawas.status');
    Route::get('/pengawas/detail_angsuran/{id}', [PengawasController::class, 'showdetailangsuran'])->name('pengawas.detail_angsuran');
});

Route::middleware(['userAkses:sekretaris'])->group(function () {
    Route::get('/sekretaris/dashboard',[SekretarisController::class,'index']);
    Route::get('/sekretaris/data_anggota',[SekretarisController::class,'DataAnggota']);
    Route::get('/sekretaris/data_pribadi',[SekretarisController::class,'data_pribadi'])->name('data_pribadi_sekretaris');
    Route::get('/sekretaris/detail_pribadi/{id}', [SekretarisController::class, 'showdetailprib'])->name('detail_pribadi_sekretaris');
    Route::get('/sekretaris/detail_simp_prib/{id}', [SekretarisController::class, 'showshimpananprib'])->name('simpanan_pribadi_sekretaris');
    Route::get('/sekretaris/angsuran/{id}', [SekretarisController::class, 'showangsuran'])->name('sekretaris.angsuran');
    Route::get('/sekretaris/detail_angsuran/{id}', [SekretarisController::class, 'showdetailangsuran'])->name('sekretaris.detail_angsuran');
    Route::get('/sekretaris/detail/{id}', [SekretarisController::class, 'show'])->name('sekretaris.detail_PeminjamanBiasa');
    Route::get('/sekretaris/detail_pribadi/{id}', [SekretarisController::class, 'showdetailprib'])->name('detail_pribadi_sekretaris');
    Route::get('/sekretaris/detail_simp_prib/{id}', [SekretarisController::class, 'showshimpananprib'])->name('simpanan_pribadi_sekretaris');
    Route::get('/sekretaris/formbiasa',[SekretarisController::class,'biasa']);
    Route::get('/sekretaris/formkhusus',[SekretarisController::class,'khusus']);
    Route::get('/sekretaris/formurgent',[SekretarisController::class,'urgent']);
    Route::post('/sekretaris/formbiasa', [SekretarisController::class, 'ketuapinjam'])->name('sekretaris.store');
    Route::post('/sekretaris/formkhusus', [SekretarisController::class, 'ketuapinjam'])->name('sekretaris.store');
    Route::post('/sekretaris/formurgent', [SekretarisController::class, 'ketuapinjam'])->name('sekretaris.store');
    Route::get('/sekretaris/status', [SekretarisController::class, 'status_prib'])->name('sekretaris.status');

});

Route::middleware(['userAkses:kabag'])->group(function () {
    Route::get('/kabag/dashboard',[KabagController::class,'index']);
    Route::get('/kabag/data_pribadi',[KabagController::class,'data_pribadi'])->name('data_pribadi');
    Route::get('/kabag/status_biasa',[PeminjamanBiasaController::class,'index_kabag']);
    Route::get('/kabag/detail/{id}', [KabagController::class, 'show'])->name('kabag.detail_PeminjamanBiasa');
    Route::get('/kabag/detail_pribadi/{id}', [KabagController::class, 'showdetailprib'])->name('detail_pribadi_kabag');
    Route::get('/kabag/detail_simp_prib/{id}', [KabagController::class, 'showshimpananprib'])->name('simpanan_pribadi_kabag');
    Route::get('/kabag/formbiasa',[KabagController::class,'biasa']);
    Route::get('/kabag/formkhusus',[KabagController::class,'khusus']);
    Route::get('/kabag/formurgent',[KabagController::class,'urgent']);
    Route::post('/kabag/formbiasa', [KabagController::class, 'ketuapinjam'])->name('kabag.store');
    Route::post('/kabag/formkhusus', [KabagController::class, 'ketuapinjam'])->name('kabag.store');
    Route::post('/kabag/formurgent', [KabagController::class, 'ketuapinjam'])->name('kabag.store');
    Route::get('/kabag/status', [KabagController::class, 'status_prib'])->name('kabag.status');
    Route::get('/kabag/detail_angsuran/{id}', [KabagController::class, 'showAngsuran'])->name('kabag.detail_angsuran');
});

Route::middleware(['userAkses:sdm'])->group(function () {
    Route::get('/sdm/dashboard',[SdmController::class,'index']);
    Route::get('/sdm/data_pribadi',[SdmController::class,'data_pribadi'])->name('data_pribadi');
    Route::get('/sdm/status_biasa',[PeminjamanBiasaController::class,'index_sdm']);
    Route::get('/sdm/detail/{id}', [SdmController::class, 'show'])->name('sdm.detail_PeminjamanBiasa');
    Route::get('/sdm/detail_pribadi/{id}', [SdmController::class, 'showdetailprib'])->name('detail_pribadi_sdm');
    Route::get('/sdm/detail_simp_prib/{id}', [SdmController::class, 'showshimpananprib'])->name('simpanan_pribadi_sdm');
    Route::get('/sdm/formbiasa',[SdmController::class,'biasa']);
    Route::get('/sdm/formkhusus',[SdmController::class,'khusus']);
    Route::get('/sdm/formurgent',[SdmController::class,'urgent']);
    Route::post('/sdm/formbiasa', [SdmController::class, 'ketuapinjam'])->name('sdm.store');
    Route::post('/sdm/formkhusus', [SdmController::class, 'ketuapinjam'])->name('sdm.store');
    Route::post('/sdm/formurgent', [SdmController::class, 'ketuapinjam'])->name('sdm.store');
    Route::get('/sdm/status', [SdmController::class, 'status_prib'])->name('sdm.status');
    Route::get('/sdm/detail_angsuran/{id}', [SdmController::class, 'showAngsuran'])->name('sdm.detail_angsuran');
});

Route::middleware(['userAkses:anggota'])->group(function () {
    Route::get('/anggota/dashboard',[AnggotaController::class,'index']);
    Route::get('/anggota/formbiasa',[PeminjamanController::class,'biasa']);
    Route::get('/anggota/formkhusus',[PeminjamanController::class,'khusus']);
    Route::get('/anggota/formurgent',[PeminjamanController::class,'urgent']);
    Route::post('/anggota/formbiasa', [PeminjamanBiasaController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/formkhusus', [PeminjamanBiasaController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/formurgent', [PeminjamanBiasaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/formbiasa', [PeminjamanBiasaController::class, 'create'])->name('anggota.create');
    Route::get('/anggota/detail_anggota/{id}', [AnggotaController::class, 'showDetailAnggota'])->name('detail_anggota');
    Route::get('/anggota/detail_simpanan/{id}', [AnggotaController::class, 'detailSimpanan'])->name('detail_simpanan');
    Route::get('/anggota/detail/{id}', [PeminjamanBiasaController::class, 'showanggota'])->name('anggota.detail_PeminjamanBiasa');
    Route::get('/anggota/detail_angsuran/{id}', [PeminjamanBiasaController::class, 'showAngsuran'])->name('anggota.detail_angsuran');
    Route::get('/anggota/status', [PeminjamanBiasaController::class, 'index'])->name('anggota.status');
});
// routes/web.php

Route::post('/ketua/validasi-peminjaman-biasa/{id}', [KetuaController::class,'validasiPeminjamanBiasa'])->name('ketua.validasi_PeminjamanBiasa');
Route::post('/ketua/validasi-peminjaman-urgent/{id}', [KetuaController::class,'validasiPeminjamanUrgent'])->name('ketua.validasi_PeminjamanUrgent');

#pengawas

Route::post('/pengawas/validasi-peminjaman-biasa/{id}', [PengawasController::class,'validasiPeminjamanBiasa'])->name('pengawas.validasi_PeminjamanBiasa');

#bendahara


Route::post('/bendahara/validasi-peminjaman-biasa/{id}', [BendaharaController::class,'validasiPeminjamanBiasa'])->name('bendahara.validasi_PeminjamanBiasa');
Route::post('/bendahara/validasi-peminjaman-urgent/{id}', [BendaharaController::class,'validasiPeminjamanUrgent'])->name('bendahara.validasi_PeminjamanUrgent');

#anggota




Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register', function () {
    return view('register');
})->name('register.form');
