<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

//login


Route::pattern('id','[0-9]+'); // artinya ketikaada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');




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

//Route::get('/', [AuthController::class, 'login']);
//Route::get('/', [WelcomeController::class, 'index']);
//Route::group(['prefix' => 'user'], function () {
Route::middleware(['auth'])->group(function(){ //artinya semua route di dalam group ini harus login dulu
    Route::get('/', [WelcomeController::class,'index']);
    
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/user', [UserController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/user/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/user/create', [UserController::class, 'create']);   //menampilkan hal form tambah user 
        Route::post('/user', [UserController::class, 'store']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']);   
        Route::get('/user/ajax', [UserController::class, 'store_ajax']);           
        Route::get('/user/{id}', [UserController::class, 'show']);       //menampilkan detail user
        Route::get('/user/{id}/edit', [UserController::class, 'edit']);  //menampilkan hal form edit user
        Route::put('/user/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/user/{id}', [UserController::class, 'destroy']); //menghapus data user
    });


    //Route::group(['prefix' => 'level'], function () {
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::get('/level', [LevelController::class, 'index']);
        //Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/level/list', [LevelController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);   //menampilkan hal form tambah user 
        Route::post('/level', [LevelController::class, 'store']);         //menyimpan data user baru
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);   
        Route::get('/level/ajax', [LevelController::class, 'store_ajax']);  
        Route::get('/level/{id}', [LevelController::class, 'show']);       //menampilkan detail user
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  //menampilkan hal form edit user
        Route::put('/level/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); //menghapus data user
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function() {
    //Route::group(['prefix' => 'kategori'], function(){
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
        Route::get('/kategori/create', [KategoriController::class, 'create']);
        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::get('/kategori/ajax', [KategoriController::class, 'store_ajax']);  
        Route::get('/kategori/{id}', [KategoriController::class, 'show']);
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']); 
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
    });


    // Route::group(['prefix' => 'barang'], function(){
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function() {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create', [BarangController::class, 'create']);
        Route::post('/barang', [BarangController::class, 'store']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
        Route::get('/barang/ajax', [BarangController::class, 'store_ajax']);  
        Route::get('/barang/{id}', [BarangController::class, 'show']);
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']); 
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/barang/{id}', [BarangController::class, 'update']);
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
    });

    //Route::group(['prefix' => 'supplier'], function(){
        Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/supplier', [SupplierController::class, 'index']);
        Route::post('/supplier/list', [SupplierController::class, 'list']);
        Route::get('/supplier/create', [SupplierController::class, 'create']);
        Route::post('/supplier', [SupplierController::class, 'store']);
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::get('/supplier/ajax', [SupplierController::class, 'store_ajax']);  
        Route::get('/supplier/{id}', [SupplierController::class, 'show']);
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']); 
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);
        Route::put('/supplier/{id}', [SupplierController::class, 'update']);
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);
    });
});