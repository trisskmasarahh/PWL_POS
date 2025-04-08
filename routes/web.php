<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KatagoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SuplierController;
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

    Route::pattern('id', '[0-9]+');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postlogin']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'postRegister']);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [WelcomeController::class, 'index']);
    
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/list', [UserController::class, 'list']);
            Route::get('/create', [UserController::class, 'create']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);
            Route::post('/ajax', [UserController::class, 'store_ajax']);
            Route::get('/{id}/show_ajax', [UserController::class, 'show']);
            Route::get('/{id}/edit', [UserController::class, 'edit']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
            Route::get('/user/{id}', [UserController::class, 'show']);

        });
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function (){
            Route::prefix('level')->group(function () {
                Route::get('/', [LevelController::class, 'index']);
                Route::get('/list', [LevelController::class, 'list']);
                Route::get('/create', [LevelController::class, 'create']);
                Route::post('/', [LevelController::class, 'store']);
                Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
                Route::post('/ajax', [LevelController::class, 'store_ajax']);
                Route::get('/{id}/show_ajax', [LevelController::class, 'show']);
                Route::get('/{id}/edit', [LevelController::class, 'edit']);
                Route::put('/{id}', [LevelController::class, 'update']);
                Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
                Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
                Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
                Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
                Route::delete('/{id}', [LevelController::class, 'destroy']); 
            });
        
        });
        
        Route::group(['prefix' => 'katagori'], function () {
            Route::get('/', [KatagoriController::class, 'index']);
            Route::delete('/{id}', [KatagoriController::class, 'destroy']);
            Route::get('/list', [KatagoriController::class, 'list']);
            Route::get('/create', [KatagoriController::class, 'create']);
            Route::post('/', [KatagoriController::class, 'store']);
            Route::get('/create_ajax', [KatagoriController::class, 'create_ajax']);
            Route::post('/ajax', [KatagoriController::class, 'store_ajax']);
            Route::get('/{id}/show_ajax', [KatagoriController::class, 'show']);
            Route::get('/{id}/edit', [KatagoriController::class, 'edit']);
            Route::put('/{id}', [KatagoriController::class, 'update']);
            Route::get('/{id}/edit_ajax', [KatagoriController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KatagoriController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [KatagoriController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KatagoriController::class, 'delete_ajax']);
            Route::delete('/{id}', [KatagoriController::class, 'destroy']);
        });

        Route::group(['prefix' => 'suplier'], function () {
            Route::get('/', [SuplierController::class, 'index']);
            Route::get('/list', [SuplierController::class, 'list']);
            Route::get('/create', [SuplierController::class, 'create']);
            Route::post('/', [SuplierController::class, 'store']);
            Route::get('/create_ajax', [SuplierController::class, 'create_ajax']);
            Route::post('/ajax', [SuplierController::class, 'store_ajax']);
            Route::get('/{id}/show_ajax', [SuplierController::class, 'show']);
            Route::get('/{id}/edit', [SuplierController::class, 'edit']);
            Route::put('/{id}', [SuplierController::class, 'update']);
            Route::get('/{id}/edit_ajax', [SuplierController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [SuplierController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [SuplierController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [SuplierController::class, 'delete_ajax']);
            Route::delete('/{id}', [SuplierController::class, 'destroy']);
        });
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);
            Route::get('/list', [BarangController::class, 'list']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post('/', [BarangController::class, 'store']);
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/ajax', [BarangController::class, 'store_ajax']);
            Route::get('/{id}/show_ajax', [BarangController::class, 'show']);
            Route::get('/{id}/edit', [BarangController::class, 'edit']);
            Route::put('/{id}', [BarangController::class, 'update']);
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            Route::delete('/{id}', [BarangController::class, 'destroy']);
        });

    });
        // Route::group(['prefix' => 'stok'], function () {
        //     Route::get('/', [StokController::class, 'index']);
        //     Route::get('/list', [StokController::class, 'list']);
        //     Route::get('/create', [StokController::class, 'create']);
        //     Route::post('/', [StokController::class, 'store']);
        //     Route::get('/{id}', [StokController::class, 'show']);
        //     Route::get('/{id}/edit', [StokController::class, 'edit']);
        //     Route::put('/{id}', [StokController::class, 'update']);
        //     Route::delete('/{id}', [StokController::class, 'destroy']);
        // });
    // });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KatagoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);

// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}' , [UserController::class, 'ubah']);

// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// //layouting
// Route:: get('/', [WelcomeController::class, 'index']);

// Route::group(['prefix' => 'user'], function () {

//     Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal user

//     Route::get('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json untuk datatable

//     Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user

//     Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']);// menyimpan  data user baru ajax

//     Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user

//     Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit user

//     Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);// pengeditan menggunkan ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);

//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);//penghapusan menggunakan ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
//     Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user

// });
//  // tugas praktikum 
//     //Barang 
//     Route::group(['prefix' => 'barang'], function(){
//         Route::get('/', [BarangController::class, 'index']);
//         Route::get('/list', [BarangController::class, 'list']);
//         Route::get('/create', [BarangController::class,'create']);
//         Route::post('/', [BarangController::class, 'store']);
//         // Route::get('/{id}', [BarangController::class, 'show']);
//         Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
//         Route::post('/ajax', [BarangController::class, 'store_ajax']);
//         Route::get('/{id}/show_ajax', [BarangController::class, 'show']);
//         Route::get('/{id}/edit', [BarangController::class, 'edit']);
//         Route::put('/{id}', [BarangController::class, 'update']);
//         Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
//         Route::delete('/{id}', [BarangController::class, 'destroy']);
//     });
//     //m_level
//     // Routes for Level
//         Route::group(['prefix' => 'level'], function () {
//             Route::get('/', [LevelController::class, 'index']);
//             Route::get('/list', [LevelController::class, 'list']);
//             Route::get('/create', [LevelController::class, 'create']);
//             Route::post('/', [LevelController::class, 'store']); // Menambahkan rute POST
//             Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
//             Route::post('/ajax', [LevelController::class, 'store_ajax']);
//             Route::get('/{id}/show_ajax', [LevelController::class, 'show']);
//             Route::get('/{id}/edit', [LevelController::class, 'edit']);
//             Route::put('/{id}', [LevelController::class, 'update']);
//             Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
//             Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
//             Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
//             Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
//             Route::delete('/{id}', [LevelController::class, 'destroy']);
//         });

//         // Routes for Kategori
//         Route::group(['prefix' => 'katagori'], function () {
//             Route::get('/', [KatagoriController::class, 'index']);
//             Route::get('/list', [KatagoriController::class, 'list']);
//             Route::get('/create', [KatagoriController::class, 'create']);
//             Route::post('/', [KatagoriController::class, 'store']); // Sudah ada
//             Route::get('/create_ajax', [KatagoriController::class, 'create_ajax']);
//             Route::post('/ajax', [KatagoriController::class, 'store_ajax']);
//             Route::get('/{id}/show_ajax', [KatagoriController::class, 'show']);
//             Route::get('/{id}/edit', [KatagoriController::class, 'edit']);
//             Route::put('/{id}', [KatagoriController::class, 'update']);
//             Route::get('/{id}/edit_ajax', [KatagoriController::class, 'edit_ajax']);
//             Route::put('/{id}/update_ajax', [KatagoriController::class, 'update_ajax']);
//             Route::get('/{id}/delete_ajax', [KatagoriController::class, 'confirm_ajax']);
//             Route::delete('/{id}/delete_ajax', [KatagoriController::class, 'delete_ajax']);
//             Route::delete('/{id}', [KatagoriController::class, 'destroy']);
        
//             });

//         // Routes for Suplier
//         Route::group(['prefix' => 'suplier'], function () {
//             Route::get('/', [SuplierController::class, 'index']);
//             Route::get('/list', [SuplierController::class, 'list']);
//             Route::get('/create', [SuplierController::class, 'create']);
//             Route::post('/', [SuplierController::class, 'store']); // Menambahkan rute POST
//             Route::get('/create_ajax', [SuplierController::class, 'create_ajax']);
//             Route::post('/ajax', [SuplierController::class, 'store_ajax']);
//             Route::get('/{id}/show_ajax', [SuplierController::class, 'show']);
//             Route::get('/{id}/edit', [SuplierController::class, 'edit']);
//             Route::put('/{id}', [SuplierController::class, 'update']);
//             Route::get('/{id}/edit_ajax', [SuplierController::class, 'edit_ajax']);
//             Route::put('/{id}/update_ajax', [SuplierController::class, 'update_ajax']);
//             Route::get('/{id}/delete_ajax', [SuplierController::class, 'confirm_ajax']);
//             Route::delete('/{id}/delete_ajax', [SuplierController::class, 'delete_ajax']);
//             Route::delete('/{id}', [SuplierController::class, 'destroy']);
        
        // });
    