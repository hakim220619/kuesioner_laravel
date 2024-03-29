<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\pages\JurusanController;
use App\Http\Controllers\pages\KelasController;
use App\Http\Controllers\pages\KuesionerController;
use App\Http\Controllers\pages\LabController;
use App\Http\Controllers\pages\PengajarController;
use App\Http\Controllers\pages\PertanyaanController;
use App\Http\Controllers\pages\SiswaController;

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
// authentication
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/login', [LoginBasic::class, 'login_action'])->name('login.action');
// Main Page Route

Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');


Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginBasic::class, 'logout'])->name('logoutall');
    Route::get('/dashboard', [HomePage::class, 'index'])->name('dashboard');

    Route::get('/kuesioner/{id}', [KuesionerController::class, 'index'])->name('kuesioner');
    Route::get('/lab-list/{id}', [KuesionerController::class, 'lab'])->name('kuesioner.lab');
    Route::get('/perpustakaan', [KuesionerController::class, 'perpustakaan'])->name('kuesioner.perpustakaan');
    Route::get('/list-kuesioner', [KuesionerController::class, 'listkuesioner'])->name('kuesioner.listkuesioner');
    Route::get('/list-lab', [KuesionerController::class, 'listlab'])->name('kuesioner.listlab');
    Route::post('/kuesionerAdd', [KuesionerController::class, 'add'])->name('kuesioner.add');
    Route::post('/load_data', [KuesionerController::class, 'load_data'])->name('load_data.kuesioner');
    Route::get('/keusionerall', [KuesionerController::class, 'keusionerall'])->name('load_data.keusionerall');

    //siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa-add', [SiswaController::class, 'add'])->name('siswa.add');
    Route::post('/siswa-edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::get('/siswa/{id}', [SiswaController::class, 'delete'])->name('siswa.delete');
    //kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::post('/kelas-add', [KelasController::class, 'add'])->name('kelas.add');
    Route::post('/kelas-edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::get('/kelas/{id}', [KelasController::class, 'delete'])->name('kelas.delete');
    //jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan');
    Route::post('/jurusan-add', [JurusanController::class, 'add'])->name('jurusan.add');
    Route::post('/jurusan-edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::get('/jurusan/{id}', [JurusanController::class, 'delete'])->name('jurusan.delete');
    //jurusan
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan');
    Route::post('/pertanyaan-add', [PertanyaanController::class, 'add'])->name('pertanyaan.add');
    Route::post('/pertanyaan-edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
    Route::get('/pertanyaan/{id}', [PertanyaanController::class, 'delete'])->name('pertanyaan.delete');

    //home

    Route::get('/perhitunganpengajar', [HomePage::class, 'perhitunganpengajar'])->name('home.perhitunganpengajar');
    Route::get('/perhitunganLab', [HomePage::class, 'perhitunganLab'])->name('home.perhitunganLab');
    Route::get('/perhitunganperpus', [HomePage::class, 'perhitunganperpus'])->name('home.perhitunganperpus');

    //lab
    Route::get('/lab', [LabController::class, 'index'])->name('lab');
    Route::post('/lab-add', [LabController::class, 'add'])->name('lab.add');
    Route::post('/lab-edit', [LabController::class, 'edit'])->name('lab.edit');
    Route::get('/lab/{id}', [LabController::class, 'delete'])->name('lab.delete');

    //lab
    Route::get('/pengajar', [PengajarController::class, 'index'])->name('pengajar');
    Route::post('/pengajar-add', [PengajarController::class, 'add'])->name('pengajar.add');
    Route::post('/pengajar-edit', [PengajarController::class, 'edit'])->name('pengajar.edit');
    Route::get('/pengajar/{id}', [PengajarController::class, 'delete'])->name('pengajar.delete');

    //hasil
    Route::get('/hasil', [HomePage::class, 'hasil'])->name('hasil');
    Route::get('/getGuru/{id}', [HomePage::class, 'getGuru'])->name('getGuru');

});
