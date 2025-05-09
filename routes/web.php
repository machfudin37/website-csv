<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\TanamanController;


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
// Login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// Register
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
// Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('daerah', DaerahController::class);
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('dasboard', [DasboardController::class, 'index'])->name('dasboard');
    Route::get('penyakit', [PenyakitController::class, 'index'])->name('penyakit');
    Route::get('filterdatapenyakit', [PenyakitController::class, 'filterdatapenyakit'])->name('filterdatapenyakit');
    Route::post('importcsvpenyakit', [PenyakitController::class, 'importcsvpenyakit'])->name('importcsvpenyakit');
    Route::get('exportpdfpenyakit', [PenyakitController::class, 'exportpdfpenyakit'])->name('exportpdfpenyakit');
    Route::get('exportpdfpenyakit', [PenyakitController::class, 'exportpdfpenyakit'])->name('exportpdfpenyakit');
    Route::get('exportpdfdatepenyakit', [PenyakitController::class, 'exportpdfdatepenyakit'])->name('exportpdfdatepenyakit');
    Route::get('exportpdfsearchpenyakit', [PenyakitController::class, 'exportpdfsearchpenyakit'])->name('exportpdfsearchpenyakit');
    Route::get('chartpenyakit', [PenyakitController::class, 'chartjumlahpenyakitperbulan'])->name('chartpenyakit');
    Route::get('tanaman', [TanamanController::class, 'index'])->name('tanaman');
    Route::get('filterdatatanaman', [TanamanController::class, 'filterdatatanaman'])->name('filterdatatanaman');
    Route::post('importcsvtanamantanaman', [TanamanController::class, 'importcsvtanaman'])->name('importcsvtanaman');
    Route::get('exportpdftanaman', [TanamanController::class, 'exportpdftanaman'])->name('exportpdftanaman');
    Route::get('exportpdfdatetanaman', [TanamanController::class, 'exportpdfdatetanaman'])->name('exportpdfdatetanaman');
    Route::get('exportpdfsearchtanaman', [TanamanController::class, 'exportpdfsearchtanaman'])->name('exportpdfsearchtanaman');
    Route::get('charttanaman', [TanamanController::class, 'chartjumlahtanamanperbulan'])->name('charttanaman');
});
