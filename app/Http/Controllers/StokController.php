<?php
namespace App\Http\Controllers;

use App\Models\StokModelModel;
use App\Models\BarangModel;
use App\Models\kategoriModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\SupplierModelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    //Menampilkan halaman awal m_barang
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Stok Barang',
            'list'=> ['Home','stok barang']
        ];
        $page = (object)[
            'title'=> 'Daftar Stok Barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'stok barang';
        $supplier = SupplierModel::all(); //ambil data kategori untuk filter kategori 
        return view('stok.index', ['breadcrumb'=> $breadcrumb, 'page' =>$page, 'supplier'=> $supplier, 'activeMenu'=> $activeMenu]);
    }

    //Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $stok = StokModel::with('barang', 'supplier','user');

        // Filter based on category_id if exists
        if ($request->filter_supplier) {
            $stok->whereHas('supplier', function($query) use ($request) {
                $query->where('supplier_id', $request->filter_supplier);
            });
        
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('supplier_nama', function($stok) {
                return $stok->supplier->supplier_nama; // Mengambil supplier_nama dari relasi supplier
            })
            ->addColumn('barang_nama', function($stok) {
                return $stok->barang->barang_nama; // Mengambil barang_nama dari relasi barang
            })
            ->addColumn('nama', function($stok) {
                return $stok->user ? $stok->user->nama : '-'; // Tampilkan '-' jika user tidak ditemukan
            })
            ->addColumn('aksi', function ($stok) { // Action buttons
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    //Menampilkan halaman form tambah barang
    public function create(){
        $breadcrumb =(object)[
            'title'=>'Tambah Stok Barang',
            'list'=>['Home', 'data stok barang']
        ];
        $page =(object)[
            'title'=>'Tambah Stok Barang baru'
        ];
        $kategori = kategoriModel::all();
        $activeMenu = 'kategori';
        return view('stok.create',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu,'kategori'=>$kategori]);
    }
    //Menyimpan data barang baru
    public function store(Request $request){
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        StokModel::create([
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Data stok barang berhasil disimpan');
    }

    // Menampilkan detail stok barang
    public function show(string $stok_id){
    // Mengambil data stok beserta barang dan supplier terkait
    $stok = StokModel::with('barang', 'supplier', 'user')->find($stok_id);
    // Breadcrumb dan informasi halaman
    $breadcrumb = (object)[
        'title' => 'Detail Stok Barang',
        'list' => ['Home', 'Stok Barang', 'Detail']
    ];
    $page = (object)[
        'title' => 'Detail Data Stok Barang'
    ];
    $activeMenu = 'stok_barang';

    return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }


    // Menghapus data stok barang
    public function destroy(string $stok_id){
        $stok = StokModel::find($stok_id);

        if(!$stok){
            return redirect('/stok')->with('error','Data stok tidak ditemukan');
        }

        try{
            StokModel::destroy($stok_id);
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e){
            return redirect('/stok')->with('error','Data stok gagal dihapus karena masih terdapat data lain yang terkait dengan stok ini');
        }
    }
    public function create_ajax()
    {
        // Mengambil daftar barang dan supplier untuk digunakan dalam form
        $barang = BarangModel::all(); // Get all items for the dropdown
        $supplier = SupplierModel::all();
        $user = UserModel::all(); // Get all suppliers for the dropdown

        // Menampilkan form tambah stok dengan AJAX
        return view('stok.create_ajax', compact('barang', 'supplier', 'user'));
    }

    // Menyimpan data barang menggunakan AJAX
    // Menyimpan data stok menggunakan AJAX
        public function store_ajax(Request $request)
        {
            // cek apakah request berupa ajax
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date_format:Y-m-d H:i:s',
                'stok_jumlah' => 'required|integer',
                ];
                // use Illuminate\Support\Facades\Validator;
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi gagal.',
                        'msgField' => $validator->errors()
                    ]);
                }
                
                StokModel::create($request->all());
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data user berhasil disimpan'
                ]);
            }
            
            redirect('/');
        }


    // Menampilkan detail barang dengan AJAX
    public function show_ajax(string $stok_id)
    {
        // Mengambil data stok berdasarkan ID dan mengikutsertakan data barang dan supplier
        $stok = StokModel::with('barang', 'supplier', 'user')->find($stok_id);

        // Mengembalikan view dengan data stok
        return view('stok.show_ajax', ['stok' => $stok]);
    }


    // Menampilkan form edit barang dengan AJAX
    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        return view('stok.edit_ajax', ['stok' => $stok, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'   => 'required|integer',
                'barang_id'     => 'required|integer',
                'user_id'       => 'required|integer',
                'stok_tanggal' => 'required|date', //nama harus diisi, berupa string, dan maksimal 100 karakter
                'stok_jumlah'   => 'required|integer'
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
            $check = StokModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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
    public function confirm_ajax(string $id)
    {
        $stok = StokModel::find($id);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
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
        return view('stok.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_stok'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'supplier_id'   => $value['A'],
                            'barang_id'     => $value['B'],
                            'user_id'       => $value['C'],
                            'stok_tanggal'  => $value['D'],
                            'stok_jumlah'   => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    StokModel::insertOrIgnore($insert);
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
        }
        return redirect('/');
    }
    public function export_excel()
    {
        // ambil data barang yang akan di export
        $stok = StokModel::select('supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->orderBy('supplier_id')
            ->with('supplier')
            ->with('barang')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Supplier');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Tanggal Stok');
        $sheet->setCellValue('F1', 'Jumlah Stok');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->supplier->supplier_nama);
            $sheet->setCellValue('C' . $baris, $value->barang->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->user->username);
            $sheet->setCellValue('E' . $baris, $value->stok_tanggal);
            $sheet->setCellValue('F' . $baris, $value->stok_jumlah);
            $baris++;
            $no++;
        }
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Stok'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel
    public function export_pdf()
    {
        $stok = StokModel::select('supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->orderBy('supplier_id')
            ->orderBy('user_id')
            ->with('supplier')
            ->with('barang')
            ->with('user')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data stok' . date('Y-m-d H:i:s') . '.pdf');
    }
}
