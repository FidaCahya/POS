<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WelcomeController;
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

//Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::prefix('category')->group(function() {
//     Route::get('food-beverage', [ProductController::class, 'foodBeverage'])->name('category.food-beverage');
//     Route::get('beauty-health', [ProductController::class, 'beautyHealth'])->name('category.beauty-health');
//     Route::get('home-care', [ProductController::class, 'homeCare'])->name('category.home-care');
//     Route::get('baby-kid', [ProductController::class, 'babyKid'])->name('category.baby-kid');

// });
 
//Route::get('user/{id}/name/{name}', [UserController::class, 'showProfile'])->name('user.profile');

Route::get('transaction', [TransactionController::class, 'showTransaction'])->name('transaction.index');

//JS 3 | Praktikum 4
//Route::get('/level', [LevelController::class, 'index']);

//JS 3 | Praktikum 5
//Route::get('/kategori', [KategoriController::class, 'index']);

//JS 3 | Praktikum 6
//Route::get ('/user', [UserController::class, 'index']);

//Praktikum 2.6 no 5 JS 4
Route::get('/user/tambah', [UserController::class, 'tambah']);

//Praktikum 2.6 no 8 JS 4
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

//Praktikum 2.6 no 12 JS 4
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

//Praktikum 2.6 no 15 JS 4
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
Route::get('/', [WelcomeController::class, 'index']);