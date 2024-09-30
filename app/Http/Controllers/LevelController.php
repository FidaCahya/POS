<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    //public function index()
    //{
        // // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // // return 'Insert data baru berhasil';

        // //$row =  DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // //return 'Update data berhasil. Jumlah data yang diupdate: ' . $row.' baris';
    
        // // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // // return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row.' baris';
    
        // $data = DB::select('select * from m_level');
        // return view('level', ['data' => $data]);
    //}

    public function index(){
    $breadcrumb = (object) [
        'title' => 'Daftar Level',
        'list'  => ['Home', 'Level']
    ];

    $page = (object)[
        'title' => 'Daftar Level user yang terdaftar dalam sistem'
    ];

    $activeMenu = 'level'; //set menu yag sedang aktif
    
    return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level'
        ];

        $activeMenu = 'level'; //set menu yag sedang aktif
    
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
        
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|unique:m_level,level_kode',
            'level_nama' => 'required',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil ditambahkan');
    }

    // Menampilkan detail level
    public function show(string $level_id){
        $level = levelModel::find($level_id);
        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home', 'level', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail Level'
        ];
        $activeMenu = 'level';
        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit level
    public function edit(string $level_id){
        $level = levelModel::find($level_id);
        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'level', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit level'
        ];
        $activeMenu = 'level';
        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    //Menyimpan perubahan data level
    public function update(Request $request, string $level_id){
        $request->validate([
            'level_kode' => 'required|string|max:5|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);
        $level = levelModel::find($level_id);
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);
        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
    //Menghapus data level
    public function destroy(string $level_id) {    
                $check = LevelModel::find($level_id);
                if (!$check){
                    return redirect('/level')->with('error', 'Data user tidak ditemukan');
                }

                try{
                    LevelModel::destroy($level_id);
                    return redirect('/level')->with('success','Data user berhasil dihapus');
                }catch (\Illuminate\Database\QueryException $e){

                    return redirect('/level')->with('error', 'Datauser gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
                }
            }
    

}







