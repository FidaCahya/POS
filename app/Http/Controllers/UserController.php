<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


use function Laravel\Prompts\error;

class UserController extends Controller
{
    //JS 2
    // public function showProfile($id, $name)
    // {
    //     return view('user.profile', ['id' => $id, 'name' => $name]);
    // }

    // JS 3 - Praktikum 6
    
        // public function index()
        //{
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
            // $user = UserModel::with('level')->get();
            // return view('user', ['data' => $user]);

        
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

        //menampilkan halaman awal user
        public function index() {

            $breadcrumb = (object) [
                'title' => 'Daftar User',
                'list'  => ['Home', 'User']
            ];

            $page = (object)[
                'title' => 'Daftar user yang terdaftar dalam sistem'
            ];

            $activeMenu = 'user'; //set menu yag sedang aktif
            
            $level = LevelModel::all(); //ambil data level untuk filter
            return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
        }

        // public function list(Request $request)
        // {
        // $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');
        
        // //Filter data user berdasarkan level_id
        // if ($request->level_id) {
        //     $users->where('level_id', $request->level_id);
        // }
        // return DataTables::of($users)
        //     ->addIndexColumn()
        //     ->addColumn('aksi', function ($user) {
        //         $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
        //         $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
        //         $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
        //             . csrf_field() . method_field('DELETE') .
        //             '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
        //         return $btn;
        //     })
        //     ->rawColumns(['aksi'])
        //     ->make(true);
        // }

        public function create() {

        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); //ambil dta level untuk ditampilkan diform
        $activeMenu = 'user'; //set menu yag sedang aktif

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' =>  $level, 'activeMenu' => $activeMenu]);
        }

        public function store(Request $request){
            $request->validate([
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5',
                'level_id' => 'required|integer',
            ]);

            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
                'level_id' => $request->level_id,
            ]);

            return redirect('/user')->with('success', 'Datauserberhasil disimpan');
        }

        // Menampilkan detail user
        public function show(string $id)
        {
            $user = UserModel::with('level')->find($id);

            $breadcrumb = (object) [
                'title' => 'Detail User',
                'list' => ['Home', 'User', 'Detail']
            ];

            $page = (object) [
                'title' => 'Detail user'
            ];

            $activeMenu = 'user'; // set menu yang sedang aktif

            return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
        }

        // Menampilkan halaman form edit user
        // public function edit(string $id)
        // {
        //     $user = UserModel::find($id);
        //     $level = LevelModel::all();

        //     $breadcrumb = (object) [
        //         'title' => 'Detail User',
        //         'list' => ['Home', 'User', 'Edit']
        //     ];

        //     $page = (object) [
        //         'title' => 'Edit user'
        //     ];

        //     $activeMenu = 'user';   // set menu yang sedang aktif

        //     return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level'=>$level,'activeMenu' => $activeMenu]);
        // }

            // Menyimpan perubahan data user
            public function update(Request $request, string $id)
            {
            $request->validate([
                // username harus diisi, berupa string, minimal 3 karakter,
                // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
                'username' => 'required|string|min:3|unique:m_user,username, '.$id.' ,user_id',
                'nama'     => 'required|string|max:100',    // nama harus diisi, berupa string, dan maksimal 100 karakter
                'password' => 'nullable|min:5',    // password harus diisi dan minimal 5 karakter
                'level_id' => 'required|integer',    // level harus diisi dan berupa angka
            ]);

            $user = UserModel::find($id);

            $user->update([
                'username'  => $request->username,
                'nama'      => $request->nama,
                'password'  => $request->password ? bcrypt($request->password) : $user->password,  // password dienkripsi sebelum disimpan
                'level_id'  => $request->level_id,
            ]);
            
            return redirect('/user')->with('success', 'Data user berhasil diubah');
            }

            //menghapus data user
            public function destroy(string $id) {    
                $check = UserModel::find($id);
                if (!$check){
                    return redirect('/user')->with('error', 'Data user tidak ditemukan');
                }

                try{
                    UserModel::destroy($id);
                    return redirect('/user')->with('success','Data user berhasil dihapus');
                }catch (\Illuminate\Database\QueryException $e){

                    return redirect('/user')->with('error', 'Datauser gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
                }
            }

            //Praktikum 1 JS 6
            public function create_ajax(){
                $level = LevelModel::select('level_id', 'level_nama')->get();
                return view('user.create_ajax')
                            ->with('level', $level);            }
            
            //Praktikum 1 JS 6
            public function store_ajax(Request $request){
                //cek apsakah request berupa ajax
                if($request->ajax() || $request->wantsJson()){
                    $rules = [
                        'level_id' => 'required|integer', 
                        'username' => 'required|string|min:3|unique:m_user,username',
                        'nama' => 'required|string|max:100',
                        'password'=> 'required|min:5'
                    ];
                    // use Illuminate\Support\Facades\Validator;
                    $validator = Validator::make($request->all(), $rules);
                    if($validator->fails()){
                        return response()->json([
                        'status' => false, // response status, false: error/gagal, true: berhasil
                        'message' => 'Validasi Gagal',
                        'msgField' => $validator->errors(), // pesan error validasi
                        ]);
                    }  
                    
                    UserModel::create($request->all());
                    return response()->json([
                        'status' => true,
                        'message' => 'Data user berhasil disimpan'
                    ]);
                }
                return redirect('/');
            }

            //Ambil data user dalam bentuk json untuk datatables
                public function list(Request $request) 
                {
                    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                        ->with('level');

                    // Filter data user berdasarkan level_id
                    if ($request->level_id) {
                        $users->where('level_id', $request->level_id);
                    }

                    return DataTables::of($users)
                        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
                        ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                            $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                            $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                            $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                                return $btn;
                            })
                            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
                            ->make(true);
                    
                }
            // Menampilkan halaman form edit user ajax
                public function edit_ajax(string $id)
                {
                    $user = UserModel::find($id);
                    $level= LevelModel::select('level_id', 'level_nama')->get();

                    return view('user.edit_ajax',['user' => $user, 'level' => $level]);
                }
            
                public function update_ajax(Request $request, $id){
                    // cek apakah request dari ajax
                    if ($request->ajax() || $request->wantsJson()) {
                    $rules = [
                    'level_id' => 'required|integer',
                    'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                    'nama' => 'required|max:100',
                    'password' => 'nullable|min:5|max:20'
                    ];
                    // use Illuminate\Support\Facades\Validator;
                    $validator = Validator::make($request->all(), $rules);
                        if ($validator->fails()) {
                        return response()->json([
                            'status' => false, // respon json, true: berhasil, false: gagal
                            'message' => 'Validasi gagal.',
                            'msgField' => $validator->errors() // menunjukkan field mana yang error
                            ]);
                        }
                        $check = UserModel::find($id);
                        if ($check) {
                            if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request
                                $request->request->remove('password');
                            }
                            $check->update($request->all());
                            return response()->json([
                                'status' => true,
                                'message' => 'Data berhasil diupdate'
                            ]);
                        } else{
                            return response()->json([
                                'status' => false,
                                'message' => 'Data tidak ditemukan'
                            ]);
                        }   
                    }
                    return redirect('/');
                }

                public function confirm_ajax(string $id){
                    $user = UserModel::find($id);
                    return view('user.confirm_ajax', ['user' => $user]);
                }

                public function delete_ajax(Request $request, $id) 
                {
                    //cek apakah req dari ajax
                    if ($request->ajax() || $request->wantsJson()) {
                        $user = UserModel::find($id);
                        if ($user) {
                            $user->delete();
                            return response()->json([
                                'status' => true,
                                'message' => 'Data berhasil dihapus'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Data tidak ditemukan'
                            ]);
                        }
                    }
                    return redirect('/');
                }
        }
