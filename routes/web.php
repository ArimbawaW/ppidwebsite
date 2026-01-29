<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| FRONTEND CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProfilController;
use App\Http\Controllers\Frontend\HalamanStatisController as FrontendHalamanStatisController;
use App\Http\Controllers\Frontend\InformasiPublikController;
use App\Http\Controllers\Frontend\PermohonanController;
use App\Http\Controllers\Frontend\PermohonanStatusController;
use App\Http\Controllers\Frontend\KeberatanController;
use App\Http\Controllers\Frontend\BeritaController;
use App\Http\Controllers\Frontend\GaleriController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Frontend\RegulasiController;
use App\Http\Controllers\Frontend\AgendaKegiatanController;
use App\Http\Controllers\Frontend\StandarLayananController;
use App\Http\Controllers\Frontend\FaqController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\BannerManagementController;
use App\Http\Controllers\Admin\HalamanStatisController as AdminHalamanStatisController;
use App\Http\Controllers\Admin\RegulasiController as AdminRegulasiController;
use App\Http\Controllers\Admin\StandarLayananController as AdminStandarLayananController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil PPID
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/struktur-organisasi', [ProfilController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/dasar-hukum', [ProfilController::class, 'dasarHukum'])->name('dasar-hukum');
    Route::get('/tugas-fungsi', [ProfilController::class, 'tugasFungsi'])->name('tugas-fungsi');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
});

// Halaman Statis
Route::get('/halaman/{slug}', [FrontendHalamanStatisController::class, 'show'])
    ->name('halaman-statis.show');

// Informasi Publik
Route::get('/informasi-publik', [InformasiPublikController::class, 'index'])->name('informasi-publik.index');
Route::get('/informasi-publik/{id}', [InformasiPublikController::class, 'show'])->name('informasi-publik.show');
Route::get('/informasi-publik/{id}/download', [InformasiPublikController::class, 'download'])
    ->name('informasi-publik.download');

// Permohonan Informasi
Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');

// Cek Status Permohonan
Route::get('/cek-status', [PermohonanStatusController::class, 'index'])->name('permohonan.cek-status');
Route::post('/cek-status', [PermohonanStatusController::class, 'cek'])
    ->name('permohonan.cek-status.proses');

// Keberatan (Frontend)
Route::get('/keberatan', [KeberatanController::class, 'index'])->name('keberatan.index');
Route::post('/keberatan', [KeberatanController::class, 'store'])->name('keberatan.store');
Route::get('/keberatan/cek', [KeberatanController::class, 'cek'])->name('keberatan.cek');
Route::post('/keberatan/cek', [KeberatanController::class, 'cekProses'])->name('keberatan.cek.proses');
Route::post('/keberatan/{id}/tanggapan', [KeberatanController::class, 'submitTanggapan'])->name('keberatan.submit-tanggapan');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// Regulasi
Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi.index');

// Standar Layanan
Route::get('/standar-layanan', [StandarLayananController::class, 'index'])
    ->name('standar-layanan.index');
Route::get('/standar-layanan/{slug}', [StandarLayananController::class, 'show'])
    ->name('standar-layanan.show');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/under-construction', function () {
    return view('under-construction');
})->name('under.construction');

Route::get('/agenda-kegiatan', [AgendaKegiatanController::class, 'index'])
    ->name('frontend.agenda-kegiatan.index');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | PERMOHONAN
    |----------------------------------------------------------------------
    */
    Route::get('/permohonan/statistics',
        [App\Http\Controllers\Admin\PermohonanController::class, 'statistics'])
        ->name('permohonan.statistics');

    Route::post('/permohonan/{permohonan}/update-status',
        [App\Http\Controllers\Admin\PermohonanController::class, 'updateStatus'])
        ->name('permohonan.updateStatus');

    Route::get('/permohonan/{permohonan}/download/{type}',
        [App\Http\Controllers\Admin\PermohonanController::class, 'downloadFile'])
        ->name('permohonan.downloadFile');

    Route::resource('permohonan',
        App\Http\Controllers\Admin\PermohonanController::class)
        ->except(['create', 'store']);

    /*
    |----------------------------------------------------------------------
    | KEBERATAN (ADMIN)
    |----------------------------------------------------------------------
    */
    Route::resource('keberatan',
        App\Http\Controllers\Admin\KeberatanController::class)
        ->except(['create', 'store']);

        /*|----------------------------------------------------------------------
| REKAP DATA - PERMOHONAN
|----------------------------------------------------------------------
*/
Route::prefix('rekap/permohonan')->name('rekap.permohonan.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\RekapPermohonanController::class, 'index'])
        ->name('index');
    Route::post('/preview', [App\Http\Controllers\Admin\RekapPermohonanController::class, 'preview'])
        ->name('preview');
    Route::post('/export', [App\Http\Controllers\Admin\RekapPermohonanController::class, 'export'])
        ->name('export');
});
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/rekap/permohonan', [PermohonanRekapController::class, 'index'])
        ->name('rekap.permohonan');
});

/*
|----------------------------------------------------------------------
| REKAP DATA - KEBERATAN
|----------------------------------------------------------------------
*/
Route::prefix('rekap/keberatan')->name('rekap.keberatan.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\RekapKeberatanController::class, 'index'])
        ->name('index');
    Route::post('/preview', [App\Http\Controllers\Admin\RekapKeberatanController::class, 'preview'])
        ->name('preview');
    Route::post('/export', [App\Http\Controllers\Admin\RekapKeberatanController::class, 'export'])
        ->name('export');
});
    /*
    |----------------------------------------------------------------------
    | BERITA
    |----------------------------------------------------------------------
    */
    Route::resource('berita',
        App\Http\Controllers\Admin\BeritaController::class);

    /*
    |----------------------------------------------------------------------
    | INFORMASI PUBLIK
    |----------------------------------------------------------------------
    */
    Route::resource('informasi-publik',
        App\Http\Controllers\Admin\InformasiPublikController::class)
        ->parameters(['informasi-publik' => 'informasi_publik']);

    /*
    |----------------------------------------------------------------------
    | HALAMAN STATIS
    |----------------------------------------------------------------------
    */
    Route::resource('halaman-statis',
        AdminHalamanStatisController::class)
        ->parameters(['halaman-statis' => 'halamanStatis']);

    /*
    |----------------------------------------------------------------------
    | AGENDA KEGIATAN
    |----------------------------------------------------------------------
    */
    Route::resource('agenda-kegiatan',
        App\Http\Controllers\Admin\AgendaKegiatanController::class)
        ->parameters(['agenda-kegiatan' => 'agendaKegiatan']);

    /*
    |----------------------------------------------------------------------
    | GALERI
    |----------------------------------------------------------------------
    */
    Route::resource('galeri',
        App\Http\Controllers\Admin\GaleriController::class);

    /*
    |----------------------------------------------------------------------
    | KONTAK
    |----------------------------------------------------------------------
    */
    Route::resource('kontak',
        App\Http\Controllers\Admin\KontakController::class)
        ->except(['create', 'store']);

    /*
    |----------------------------------------------------------------------
    | REGULASI
    |----------------------------------------------------------------------
    */
    Route::resource('regulasi',
        AdminRegulasiController::class);

    /*
    |----------------------------------------------------------------------
    | STANDAR LAYANAN (ADMIN)
    |----------------------------------------------------------------------
    */
    Route::resource('standar-layanan',
        AdminStandarLayananController::class)
        ->parameters(['standar-layanan' => 'standarLayanan']);

    /*
    |----------------------------------------------------------------------
    | FAQ
    |----------------------------------------------------------------------
    */
    Route::resource('faq',
        AdminFaqController::class);

    /*
    |----------------------------------------------------------------------
    | BANNER SLIDER (ADMIN)
    |----------------------------------------------------------------------
    */
    Route::resource('banner-slider', BannerManagementController::class);
    Route::post('banner-slider/{bannerSlider}/toggle-status', 
        [BannerManagementController::class, 'toggleStatus'])
        ->name('banner-slider.toggle-status');
        
});
