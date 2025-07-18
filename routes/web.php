<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KursusController;


use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\TestimoniController;

use App\Http\Controllers\HalamanKursusController;

use App\Http\Controllers\Peserta\HomeController;
use App\http\Controllers\HomeController as InterfaceController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\KursusController as FrontKursusController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\Admin\MateriController as AdminMateriController;
use App\Http\Controllers\KursusController as SemuaKursusController;
/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

*/



Route::get('/', [InterfaceController::class, 'index'])->name('welcome');
Route::get('/kursus/{kursu}', [HalamanKursusController::class, 'show'])->name('kursus.show');
Route::get('/kursus', [SemuaKursusController::class, 'index'])->name('kursus.index');

// Rute otentikasi, dengan menonaktifkan registrasi publik

Auth::routes(['register' => false]);

//================================================

// RUTE UNTUK PESERTA (PENGGUNA YANG LOGIN)

//================================================

Route::middleware('auth')->group(function() {

  Route::get('/home', [HomeController::class, 'index'])->name('home');


  Route::post('/kursus/{kursus}/daftar', [FrontKursusController::class, 'daftar'])->name('kursus.daftar');

  Route::get('/materi/{kursus}', [MateriController::class, 'lanjut'])->name('materi.lanjut');

  Route::post('/materi/{materi}/selesai', [MateriController::class, 'selesaikan'])->name('materi.selesai')->middleware('auth');

});





//================================================

// RUTE UNTUK ADMINISTRATOR

//================================================

Route::middleware(['auth', 'role:Administrator'])->prefix('admin')->name('admin.')->group(function () {

 

  // Dashboard

  Route::get('/dashboard', function () {

    return view('admin.dashboard');

  })->name('dashboard');



  // CRUD Utama untuk Kursus

  Route::resource('kursus', KursusController::class);



  // --- Manajemen Kurikulum (Modul & Materi) ---

  // Halaman utama untuk mengelola kurikulum sebuah kursus

  Route::get('/kursus/{kursu}/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index');



  // Rute untuk Modul

  Route::post('/modul/{kursu}', [KurikulumController::class, 'storeModul'])->name('modul.store');

  Route::put('/modul/{modul}', [KurikulumController::class, 'updateModul'])->name('modul.update');

  Route::delete('/modul/{modul}', [KurikulumController::class, 'destroyModul'])->name('modul.destroy');

 

  // Rute untuk Materi

Route::post('/materi/{modul}', [KurikulumController::class, 'storeMateri'])->name('materi.store');

  Route::put('/materi/{materi}', [KurikulumController::class, 'updateMateri'])->name('materi.update');

  Route::delete('/materi/{materi}', [KurikulumController::class, 'destroyMateri'])->name('materi.destroy');
 
  Route::get('/materi/{materi}/isi', [AdminMateriController::class, 'isi'])->name('materi.isi');

// Route untuk memproses update/simpan konten materi
Route::put('/materi/{materi}/isi', [AdminMateriController::class, 'updateIsi'])->name('materi.isi.update');

  // --- Manajemen Testimoni ---

  // Halaman utama untuk mengelola testimoni sebuah kursus

  Route::get('/kursus/{kursu}/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');

  Route::post('/kursus/{kursu}/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');

  Route::get('/kursus/{kursu}/peserta', [KursusController::class, 'peserta'])->name('kursus.peserta');

// Tambah peserta ke kursus
Route::post('/kursus/{kursu}/peserta', [KursusController::class, 'tambahPeserta'])->name('kursus.peserta.tambah');

// Hapus peserta dari kursus
Route::delete('/kursus/{kursu}/peserta/{user}', [KursusController::class, 'hapusPeserta'])->name('kursus.peserta.hapus');



  Route::delete('/testimoni/{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');



  Route::resource('users', UserController::class);



});





//================================================

// RUTE UNTUK INSTRUCTOR

//================================================

Route::middleware(['auth', 'role:Instructor'])->group(function () {

  Route::get('/instructor/dashboard', function () {

    return '<h1>Selamat Datang di Dashboard Instructor</h1>';

  })->name('instructor.dashboard');

  // Tambahkan rute lain untuk instruktur di sini

});