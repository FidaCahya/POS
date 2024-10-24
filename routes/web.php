<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
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
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function(){ //artinya semua route di dalam group ini harus login dulu
    // Route untuk menampilkan profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');

    Route::post('/profile/upload', [UserController::class, 'uploadProfilePicture'])->name('profile.upload');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/', [WelcomeController::class,'index']);
    
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/user', [UserController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/user/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/user/create', [UserController::class, 'create']);   //menampilkan hal form tambah user 
        Route::post('/user', [UserController::class, 'store']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']);   
        Route::post('/user/ajax', [UserController::class, 'store_ajax']);           
        Route::get('/user/{id}', [UserController::class, 'show']);       //menampilkan detail user
        Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']); 
        Route::get('/user/{id}/edit', [UserController::class, 'edit']);  //menampilkan hal form edit user
        Route::put('/user/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/user/{id}', [UserController::class, 'destroy']); //menghapus data user
        Route::get('/user/import', [UserController::class, 'import']); //ajax form upload excel
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/user/export_excel', [UserController::class, 'export_excel']); //export excel
        Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);
        // Route::get('/user/profile', [UserController::class, 'showProfile'])->name('profile');
        // Route::post('/user/profile/upload', [UserController::class, 'uploadProfilePicture'])->name('profile.upload');
        // Route::post('/user/profile/edit_profile', [UserController::class, 'editProfile'])->name('profile.edit_profile');
    });


    //Route::group(['prefix' => 'level'], function () {
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::get('/level', [LevelController::class, 'index']);
        //Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/level/list', [LevelController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);   //menampilkan hal form tambah user 
        Route::post('/level', [LevelController::class, 'store']);         //menyimpan data user baru
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);   
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);  
        Route::get('/level/{id}', [LevelController::class, 'show']);       //menampilkan detail user
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); 
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  //menampilkan hal form edit user
        Route::put('/level/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); //menghapus data user
        Route::get('/level/import', [LevelController::class, 'import']); //ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']); //export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function() {
    //Route::group(['prefix' => 'kategori'], function(){
        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::post('/kategori/list', [KategoriController::class, 'list']);
        Route::get('/kategori/create', [KategoriController::class, 'create']);
        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']);  
        Route::get('/kategori/{id}', [KategoriController::class, 'show']);
        Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']); 
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
        Route::get('/kategori/import', [KategoriController::class, 'import']); //ajax form upload excel
        Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']);
        Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); //export excel
        Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']);
    });


    // Route::group(['prefix' => 'barang'], function(){
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function() {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create', [BarangController::class, 'create']);
        Route::post('/barang', [BarangController::class, 'store']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);  
        Route::get('/barang/{id}', [BarangController::class, 'show']);
        Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']); 
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/barang/{id}', [BarangController::class, 'update']);
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::get('/barang/import', [BarangController::class, 'import']); //ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); //ajax import excel
        Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); //export excel
        Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']);
    });

    //Route::group(['prefix' => 'supplier'], function(){
        Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/supplier', [SupplierController::class, 'index']);
        Route::post('/supplier/list', [SupplierController::class, 'list']);
        Route::get('/supplier/create', [SupplierController::class, 'create']);
        Route::post('/supplier', [SupplierController::class, 'store']);
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']);  
        Route::get('/supplier/{id}', [SupplierController::class, 'show']);
        Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']); 
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);
        Route::put('/supplier/{id}', [SupplierController::class, 'update']);
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);
        Route::get('/supplier/import', [SupplierController::class, 'import']); //ajax form upload excel
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']);
        Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); //export excel
        Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']);
    });
    
        Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/stok', [StokController::class, 'index']);
        Route::post('/stok/list', [StokController::class, 'list']);
        Route::get('/stok/create', [StokController::class, 'create']);
        // Route::post('/stok', [StokController::class, 'store']);
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']);
        Route::post('/stok/ajax', [StokController::class, 'store_ajax']);  
        Route::get('/stok/{id}', [StokController::class, 'show']);
        Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']); 
        Route::get('/stok/{id}/edit', [StokController::class, 'edit']);
        Route::put('/stok/{id}', [StokController::class, 'update']);
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
        Route::delete('/stok/{id}', [StokController::class, 'destroy']);
        Route::get('/stok/import', [StokController::class, 'import']); //ajax form upload excel
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']);
        Route::get('/stok/export_excel', [StokController::class, 'export_excel']); //export excel
        Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']);
    
    });


        Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        Route::post('/penjualan/list', [PenjualanController::class, 'list'])->name('penjualan.list');
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
        Route::post('/penjualan/store_ajax', [PenjualanController::class, 'store_ajax']);
        Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']);
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']);
    });
    
    });
