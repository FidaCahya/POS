<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;


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
        // Select specific columns from the BarangModel and include the 'kategori' relationship
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori'); // Load the related kategori model
        
        // Apply filter based on the 'kategori_id' if it is provided in the request
        if($request->filter_kategori){
            $barang->where('kategori_id', $request->filter_kategori);
        }

        // Use DataTables to process the query and return JSON data
        return DataTables::of($barang)
            ->addIndexColumn() // Add index column (DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // Add 'aksi' (action) column with buttons
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // Ensure the 'aksi' column is not escaped and rendered as HTML
            ->make(true); // Return the processed data to DataTables
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
    public function confirm_ajax($id) 
    { 
        $barang = BarangModel::find($id); 
        return view('barang.confirm_ajax', ['barang' => $barang]); 
    } 
    
    public function delete_ajax(Request $request, $id) 
    { 
        if($request->ajax() || $request->wantsJson()){ 
            $barang = BarangModel::find($id); 
            if($barang){ // jika sudah ditemuikan 
                $barang->delete(); // barang di hapus 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil dihapus' 
                ]); 
            }else{ 
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
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');
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
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    BarangModel::insertOrIgnore($insert);
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
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli','harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();
        
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);    // bold header
        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); // ambil nama kategori
            $baris++;
            $no++;
        }
        
        foreach(range('A', 'F') as $coloumID){
            $sheet->getColumnDimension($coloumID)->setAutoSize(true); // ambil nama kategori
        }
        
        $sheet->setTitle('Data Barang'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $barang = BarangModel::select('kategori_id','barang_kode','barang_nama','harga_beli','harga_jual')
            ->orderBy('kategori_id')
            ->orderBy('barang_kode')
            ->with('kategori')
            ->get();
        //use Barryvdh\DomPDF\Facade\PDF;
        $pdf = Pdf::loadView('barang.export_pdf', ['barang'=>$barang]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        
        $pdf->render();
        
        return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');

    }
    
}
