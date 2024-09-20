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
            //Praktikum 1 no 2 JS 4
            // $data = [
            //     'level_id' => 2,
            //     'username' => 'manager_dua',
            //     'nama' => 'Manager 2',
            //     'password' => Hash::make('12345')
            // ];

            //Praktikum 1 no 5 JS 4
            // $data = [
            //     'level_id' => 2,
            //     'username' => 'manager_tiga',
            //     'nama' => 'Manager 3',
            //     'password' => Hash::make('12345')
            // ];
            // UserModel::create($data);

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
            // $data = [
            //     'nama' => 'Pelanggan Pertama',
            // ];
            // UserModel::where('username', 'customer-1')->update($data); //update data user
            
            // //coba model akses UserModul
            // $user = UserModel::all(); //ambil semua data dr tabel m_user
            // return view('user', ['data' => $user]);
            
            //Praktikum 2.1 no 1 JS 4
            // $user = UserModel::find(1);
            // return view ('user', ['data' => $user]);

            //Praktikum 2.1 no 4 JS 4
            // $user = UserModel::where('level_id',1)->first();
            // return view ('user', ['data' => $user]);

            //Praktikum 2.1 no 6 JS 4
            // $user = UserModel::firstwhere('level_id',1);
            // return view ('user', ['data' => $user]);
            
            //Praktikum 2.1 no 8 JS 4
            // $user = UserModel::findOr(1, ['username', 'nama'], function(){
            //     abort(404);
            // });
            // return view ('user', ['data' => $user]);

            //Praktikum 2.1 no 10 JS 4
            // $user = UserModel::findOr(2, ['username', 'nama'], function(){
            //     abort(404);
            // });
            // return view ('user', ['data' => $user]);
        
            // //Praktikum 2.2 no 1 JS 4
            // $user = UserModel::findOrFail(1);
            // return view ('user', ['data' => $user]);

            // // //Praktikum 2.2 no 3 JS 4
            // $user = UserModel::where('username', 'manager9')->firstOrFail();
            // return view ('user', ['data' => $user]);

            // //Praktikum 2.3 no 1 JS 4
            // $user = UserModel::where('level_id', 2)->count();
            // dd($user);
            // return view ('user', ['data' => $user]);
            
            //Praktikum 2.3 no 3 JS 4
            // Ambil total jumlah pengguna dengan level_id 2
            //$totalUsers = UserModel::where('level_id', 2)->count();

            // Ambil daftar pengguna dengan level_id 2
            //$userList = UserModel::where('level_id', 2)->get();
            //return view('user', ['totalUsers' => $totalUsers, 'userList' => $userList]);

            //Praktikum 2.4 no 1 JS 4
            // $user = UserModel::firstOrCreate(
            //     [
            //         'username' => 'manager',
            //         'nama' => 'Manager',
            //     ]
            // );
            // return view('user', ['data'=> $user]);

            //Praktikum 2.4 no 4 JS 4
            // $user = UserModel::firstOrCreate(
            //     [
            //         'username' => 'manager22',
            //         'nama' => 'Manager Dua Dua',
            //         'password' => Hash::make('12345'),
            //         'level_id' => 2
            //     ],
            // );

            //Praktikum 2.4 no 6 JS 4
            // $user = UserModel::firstOrNew(
            //     [
            //         'username' => 'manager',
            //         'nama' => 'Manager',
            //     ]
            //     );

            //Praktikum 2.4 no 8 & 10 JS 4
            // $user = UserModel::firstOrNew(
            //     [
            //         'username' => 'manager33',
            //         'nama' => 'Manager Tiga Tiga',
            //         'password' => Hash::make('12345'),
            //         'level_id' => 2
            //     ]
            // );
            // $user->save();
            // return view('user', ['data'=> $user]);


            //Praktikum 2.5 no 1 JS 4
            // $user = UserModel::create(
            //     [
            //         'username' => 'manager55',
            //         'nama' => 'Manager55',
            //         'password' => Hash::make('12345'),
            //         'level_id' => 2
            //     ]
            // );
            // $user->username = 'manager56';

            // $user->isDirty(); //true
            // $user->isDirty('username'); //true
            // $user->isDirty('nama'); //false
            // $user->isDirty(['nama', 'username']); //true

            // $user->isClean(); //false
            // $user->isClean('username'); //false
            // $user->isClean('nama'); //true
            // $user->isClean(['nama', 'username']); //false
            
            // $user->save();

            // $user->isDirty(); // false 
            // $user->isClean(); // true
            // dd($user->isDirty());

            //Praktikum 2.5 no 3 JS 4
            // $user = UserModel::create(
            //     [
            //         'username' => 'manager11',
            //         'nama' => 'Manager11',
            //         'password' => Hash::make('12345'),
            //         'level_id' => 2
            //     ]
            // );
            // $user->username = 'manager12';

            // $user->save();
            // $user->wasChanged(); //true
            // $user->wasChanged('username'); //true
            // $user->wasChanged(['username', 'level_id']); //true
            // $user->wasChanged('nama'); //false
            // dd($user->wasChanged(['nama', 'username']));//true
        
            //Praktikum 2.5 no 2 JS 4
            //$user = UserModel::all();
            //return view('user', ['data'=> $user]);

            //Praktikum 2.7 no 2 JS 4
            // $user = UserModel::with('level')->get();
            // dd($user);

            //Praktikum 2.7 no 4 JS 4
            $user = UserModel::with('level')->get();
            return view('user', ['data' => $user]);

        }
        // //Praktikum 2.6 no 6 JS 4
        //  public function tambah () {
        //      return view('user_tambah');
        //  }

        // //Praktikum 2.6 no 8 JS 4
        // public function tambah_simpan (Request $request) {
        //     UserModel::create([
        //         'username' => $request->username,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //         'level_id' => $request->level_id
        //     ]);
        //     return redirect('/user');
        // }

        // public function ubah($id){
        //     $user = UserModel::find($id);
        //     return view('user_ubah', ['data' =>$user]);
        // }

        // //Praktikum 2.6 no 16 JS 4
        // public function ubah_simpan($id, Request $request){
        //     $user = UserModel::find($id); 

        //     $user->username = $request->username;
        //     $user->nama = $request->nama;
        //     $user->password = Hash::make('$request->password');
        //     $user->level_id = $request->level_id;

        //     $user->save();
                
        //     return redirect('/user');
        // }
        // public function hapus($id){
        //     $user = UserModel::find($id);
        //     $user->delete();

        //     return redirect('/user');
        // }

        

    
}


