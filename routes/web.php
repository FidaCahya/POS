<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
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

//Route::get('transaction', [TransactionController::class, 'showTransaction'])->name('transaction.index');

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
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   //menampilkan hal form tambah user 
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);   
    Route::get('/ajax', [UserController::class, 'store_ajax']);           
    Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan hal form edit user
    Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  //menampilkan hal form edit user
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     //menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  //Menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
});

Route::get('/level', [LevelController::class, 'index']);
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);   //menampilkan hal form tambah user 
    Route::post('/', [LevelController::class, 'store']);         //menyimpan data user baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);   
    Route::get('/ajax', [UserController::class, 'store_ajax']);  
    Route::get('/{id}', [LevelController::class, 'show']);       //menampilkan detail user
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  //menampilkan hal form edit user
    Route::put('/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);  //menampilkan hal form edit user
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);     //menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //Menyimpan perubahan data user
    Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data user
});

Route::get('/kategori',[KategoriController::class, 'index']);
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::get('/ajax', [KategoriController::class, 'store_ajax']);  
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);  //menampilkan hal form edit user
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);     //menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  //Menyimpan perubahan data user
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::get('/barang', [BarangController::class, 'index']);
Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::get('/ajax', [BarangController::class, 'store_ajax']);  
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);  //menampilkan hal form edit user
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);     //menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);  //Menyimpan perubahan data user
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'supplier'], function(){
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    Route::get('/ajax', [SupplierController::class, 'store_ajax']);  
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);  //menampilkan hal form edit user
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);     //menyimpan perubahan data user
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});