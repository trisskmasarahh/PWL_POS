<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KatagoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\KatagoriModel;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KatagoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}' , [UserController::class, 'ubah']);

Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

//layouting
Route:: get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {

    Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal user

    Route::get('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json untuk datatable

    Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user

    Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);// menyimpan  data user baru ajax

    Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user

    Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit user

    Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);

    Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user

});
 // tugas praktikum 
    Route::group(['prefix' => 'barang'], function(){
        Route::get('/', [BarangController::class, 'index']);
        Route::get('/list', [BarangController::class, 'list']);
        Route::get('/create', [BarangController::class,'create']);
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
    });
    //m_level
    // Routes for Level
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']);
            Route::get('/list', [LevelController::class, 'list']);
            Route::get('/create', [LevelController::class, 'create']);
            Route::post('/', [LevelController::class, 'store']); // Menambahkan rute POST
            Route::get('/{id}/show', [LevelController::class, 'show']);
        });

        // Routes for Kategori
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KatagoriController::class, 'index']);
            Route::get('/list', [KatagoriController::class, 'list']);
            Route::get('/create', [KatagoriController::class, 'create']);
            Route::post('/', [KatagoriController::class, 'store']); // Sudah ada
            Route::get('/{id}/show', [KatagoriController::class, 'show']);
        });

        // Routes for Suplier
        Route::group(['prefix' => 'suplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::get('/list', [SupplierController::class, 'list']);
            Route::get('/create', [SupplierController::class, 'create']);
            Route::post('/', [SupplierController::class, 'store']); // Menambahkan rute POST
            Route::get('/{id}/show', [SupplierController::class, 'show']);
        });
