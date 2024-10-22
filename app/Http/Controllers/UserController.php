<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\SerializableClosure\Signers\Hmac;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Monolog\Level;


use function Laravel\Prompts\error;

class UserController extends Controller
{
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
            public function show_ajax(string $id)
            {
                $user = UserModel::find($id);
                return view('user.show_ajax', ['user' => $user]);
            }
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
                public function import()
                {
                    return view('user.import');
                }
            
                public function import_ajax(Request $request)
                {
                    if ($request->ajax() || $request->wantsJson()) {
                        $rules = [
                            'file_user' => ['required', 'mimes:xlsx', 'max:1024']
                        ];
            
                        $validator = Validator::make($request->all(), $rules);
            
                        if ($validator->fails()) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Validasi Gagal',
                                'msgField' => $validator->errors()
                            ]);
                        }
            
                        $file = $request->file('file_user');
                        $reader = IOFactory::createReader('Xlsx');
                        $reader->setReadDataOnly(true);
                        $spreadsheet = $reader->load($file->getRealPath());
                        $sheet = $spreadsheet->getActiveSheet();
                        $data = $sheet->toArray(null, false, true, true);
            
                        $insert = [];
                        if (count($data) > 1) {
                            foreach ($data as $baris => $value) {
                                if ($baris > 1) {
                                    $insert[] = [
                                        'level_id' => $value['A'],
                                        'username' => $value['B'],
                                        'nama' => $value['C'],
                                        'password' => Hash::make('D'),
                                        'created_at' => now(),                                        
                                    ];
                                }
                            }
            
                            if (count($insert) > 0) {
                                UserModel::insertOrIgnore($insert);
                            }
            
                            return response()->json([
                                'status' => true,
                                'message' => 'Data berhasil diimport'
                            ]);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Tidak ada data yang diimport'
                            ]);
                           
                        }
                        return redirect('/');
                    }
                }

                public function export_excel(){
                    //ambil data barang yang akan di export
                    $user = UserModel::select('level_id', 'username', 'nama', 'password')
                        ->orderBy('level_id')
                        ->with('level_nama')
                        ->get();
                    
                    //load library excel
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif
                    $sheet->setCellValue('A1', 'No');
                    $sheet->setCellValue('B1', 'Username');
                    $sheet->setCellValue('C1', 'Nama');
                    $sheet->setCellValue('D1', 'Level Pengguna');
                    $sheet->getStyle('A1:D1')->getFont()->setBold(true);    // bold header
                    $no = 1;        // nomor data dimulai dari 1
                    $baris = 2;     // baris data dimulai dari baris ke 2
                    foreach ($user as $key => $value) {
                        $sheet->setCellValue('A' . $baris, $no);
                        $sheet->setCellValue('B' . $baris, $value->username);
                        $sheet->setCellValue('C' . $baris, $value->nama);
                        $sheet->setCellValue('D' . $baris, $value->level->level_nama); // ambil nama kategori
                        $baris++;
                        $no++;
                    }
                    
                    foreach(range('A', 'D') as $coloumID){
                        $sheet->getColumnDimension($coloumID)->setAutoSize(true); // ambil nama kategori
                    }
                    
                    $sheet->setTitle('Data User'); // set title sheet
                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';
            
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="' . $filename . '"');
                    header('Cache-Control: max-age=0');
                    header('Cache-Control: max-age=1');
                    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                    header('Cache-Control: cache, must-revalidate');
                    header('Pragma: public');
            
                    $writer->save('php://output');
                    exit;
                } 
                public function export_pdf() 
                {
                    $user = UserModel::select('level_id','username','nama')
                        ->orderBy('level_id')
                        ->orderBy('username')
                        ->with('level')
                        ->get();
                    //use Barryvdh\DomPDF\Facade\PDF;
                    $pdf = Pdf::loadView('user.export_pdf', ['user'=>$user]);
                    $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
                    $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
                    
                    $pdf->render();
                    
                    return $pdf->stream('Data user ' . date('Y-m-d H:i:s') . '.pdf');
            
                }

                public function showProfile()
                {
                    $user = Auth::user(); // Mendapatkan user yang sedang login
                    $activeMenu = 'profile'; // Set active menu untuk halaman profile
                    $breadcrumb = (object) [
                        'title' => 'Profile',
                        'list' => ['Home']
                    ];
                    return view('profile', compact('user', 'activeMenu', 'breadcrumb'));
                }
                public function uploadProfilePicture(Request $request)
                {
                    $request->validate([
                        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);
                    $user = Auth::user();
                    // Hapus gambar profil lama jika ada
                    if ($user->avatar) {
                        Storage::delete($user->avatar);
                    }

                    $path = $request->file('avatar')->store('avatar');

                    // Update path di database
                    $user->avatar = $path;
                    $user->save();
                    return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
                }
               
    }
