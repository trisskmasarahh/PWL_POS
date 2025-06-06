<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\LogooutController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register'); 

 // route login
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//route logout
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

 // Route Level
Route::get('levels', [LevelController::class,'index']);
Route::post('levels', [LevelController::class,'store']);
Route::get('levels/{level}', [LevelController::class,'show']);
Route::put('levels/{level}', [LevelController::class,'update']);
Route::delete('levels/{level}', [LevelController::class,'destroy']);

