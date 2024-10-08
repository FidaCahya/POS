<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class BarangController extends Controller
{
    //Menampilkan halaman awal m_barang
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list'=> ['Home','barang']
        ];
        $page = (object)[
            'title'=> 'Daftar Barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang';
        $kategori = kategoriModel::all(); //ambil data kategori untuk filter kategori 
        return view('barang.index', ['breadcrumb'=> $breadcrumb, 'page' =>$page, 'kategori'=> $kategori, 'activeMenu'=> $activeMenu]);
    }
    
    //Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori');
        //Filter data barang berdasarkan kategori_id
        if($request->kategori_id){
            $barang->where('kategori_id',$request->kategori_id);
        }
        return DataTables::of($barang)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                    return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    //Menampilkan halaman form tambah barang
    public function create(){
        $breadcrumb =(object)[
            'title'=>'Tambah Barang',
            'list'=>['Home', 'data barang']
        ];
        $page =(object)[
            'title'=>'Tambah Barang baru'
        ];
        $kategori = kategoriModel::all();
        $activeMenu = 'kategori';
        return view('barang.create',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu,'kategori'=>$kategori]);
    }
    //Menyimpan data barang baru
    public function store(Request $request){
        $request->validate([
            'kategori_id'=>'required|integer',
            'barang_kode'=>'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'=>'required|string|max:100',
            'harga_beli'=>'required|integer',
            'harga_jual'=>'required|integer'
            
        ]);
        BarangModel::create([
            'kategori_id'=>$request->kategori_id,
            'barang_kode'=>$request->barang_kode,
            'barang_nama'=>$request->barang_nama,
            'harga_beli'=>$request->harga_beli,
            'harga_jual'=>$request->harga_jual
            
        ]);
        return redirect('/barang',)->with('success','Data barang berhasil disimpan');
    }
    //Menampilkan detail barang
    public function show(string $barang_id){
        $barang = BarangModel::with('kategori')->find($barang_id);
        $breadcrumb = (object)[
            'title'=>'Detail barang',
            'list'=>['Home','Data barang','Detail'],
        ];
        $page = (object)[
            'title'=>'Detail data barang'
        ];
        $activeMenu='barang';
        return view('barang.show',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu, 'barang'=>$barang]);
    }
    //Menampilkan halaman form edit barang
    public function edit(string $barang_id){
        $barang = BarangModel::find($barang_id);
        $kategori = kategoriModel::all();
        $breadcrumb = (object)[
            'title' =>'Edit data barang',
            'list' =>['Home','data barang','edit']
        ];
        $page = (object)[
            'title'=>'Edit data barang'
        ];
        $activeMenu = 'barang';
        return view('barang.edit',['breadcrumb'=>$breadcrumb,'page'=>$page,'barang'=>$barang,'kategori'=>$kategori, 'activeMenu'=>$activeMenu]);
    }
    //Menyimpan perubahan data barang
    public function update(Request $request, string $barang_id){
        $request->validate([
            'kategori_id'=>'required|integer',
            'barang_kode'=>'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'=>'required|string|max:100',
            'harga_beli'=>'required|integer',
            'harga_jual'=>'required|integer'
        ]);
        $barang = BarangModel::find($barang_id);
        $barang->update([
            'kategori_id'=>$request->kategori_id,
            'barang_kode'=>$request->barang_kode,
            'barang_nama'=>$request->barang_nama,
            'harga_beli'=>$request->harga_beli,
            'harga_jual'=>$request->harga_jual
        ]);
        return redirect('/barang')->with('success','Data barang berhasil diubah');
    }
    //Menghapus data barang
    public function destroy(string $barang_id){
        $check = BarangModel::find($barang_id);
        if(!$check){
            return redirect('/barang')->with('error','Data user tidak ditemukan');
        }
        try{
            BarangModel::destroy($barang_id);
            return redirect('/barang')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e){
            
            return redirect('/barang')->with('error','Data user gagal dhapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }


    //Praktikum 1 JS 6
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')
            ->with('kategori', $kategori);
    }         
    
    //Praktikum 1 JS 6
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_kode' => 'required|string|unique:m_barang,barang_kode|max:10',
                'barang_nama' => 'required|string|max:100',
                'harga_beli'  => 'required|integer',
                'harga_jual'  => 'required|integer',
                'kategori_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            BarangModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        return view('barang.show_ajax', ['barang' => $barang]);
    }

    
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }
    
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_kode' => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id|max:10',
                'barang_nama' => 'required|string|max:100',
                'harga_beli'  => 'required|integer',
                'harga_jual'  => 'required|integer',
                'kategori_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }
    public function delete_ajax(string $id)
    {
        if (BarangModel::destroy($id)) {
            return response()->json(['status' => true, 'message' => 'Data barang berhasil dihapus']);
        } else {
            return response()->json(['status' => false, 'message' => 'Data barang gagal dihapus']);
        }
    }
}


    
