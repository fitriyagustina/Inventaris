<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\peminjamanController;
use App\Http\Controllers\SessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('/siswa', SiswaController::class);
Route::resource('/barang', BarangController::class);
Route::resource('/peminjaman', peminjamanController::class);

Route:: get('/sesi',[SessionController::class,'index']);
Route:: get('/sesi/logout',[SessionController::class,'logout']);
Route:: post ('/sesi/login',[SessionController::class,'login']);
Route:: get ('/login',[SessionController::class,'viewlogin']);
Route:: get('/sesi/register',[SessionController::class,'register']);
Route:: post('/sesi/create',[SessionController::class,'create']);





