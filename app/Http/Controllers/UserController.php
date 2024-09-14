<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //JS 2
    // public function showProfile($id, $name)
    // {
    //     return view('user.profile', ['id' => $id, 'name' => $name]);
    // }

    // JS 3 - Praktikum 6
    
        public function index()
        {
            // tambah data user dengan Eloquent Model
            //Praktkum 6 no 8 JS 3
            // $data = [
            //     'username' => 'customer-3',
            //     'nama' => 'Pelanggan',
            //     'password' => Hash::make('12345'),
            //     'level_id' => 3

            // ];
            //UserModel::insert($data);   //tambahkan data ke tabel m_user


            //Praktikum 6 no 10 JS 3
            $data = [
                'nama' => 'Pelanggan Pertama',
            ];
            UserModel::where('username', 'customer-1')->update($data); //update data user
            
            //coba model akses UserModul
            $user = UserModel::all(); //ambil semua data dr tabel m_user
            return view('user', ['data' => $user]);
        }
    
}


