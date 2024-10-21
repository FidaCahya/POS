<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LevelController extends Controller
{
    
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


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level'
        ];
        $level = levelModel::all();
        $activeMenu = 'level'; //set menu yag sedang aktif
    
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
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

    //Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request) 
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama',);
            
        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $level->where('level_id', $request->level_id);
        }

        return DataTables::of($level)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                    return $btn;
                })
                ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
                ->make(true);
        
    }

    public function show_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.show_ajax', ['level' => $level]);
    }

    //Praktikum 1 JS 6
    public function create_ajax(){
        //$level = LevelModel::select('level_id', 'level_nama')->get();
        return view('level.create_ajax');
    }          
    
    //Praktikum 1 JS 6
    public function store_ajax(Request $request){
        //cek apsakah request berupa ajax
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
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
            
            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    
    // Menampilkan halaman form edit user ajax
        public function edit_ajax(string $id)
        {
            $level = LevelModel::find($id);
            return view('level.edit_ajax',['level' => $level]);
        }
    
        public function update_ajax(Request $request, $id){
            // cek apakah request dari ajax
            if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
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
                $check = LevelModel::find($id);
                if ($check) {
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
            $level = LevelModel::find($id);
            return view('level.confirm_ajax', ['level' => $level]);
        }

        public function delete_ajax(Request $request, $id) 
        {
            //cek apakah req dari ajax
            if ($request->ajax() || $request->wantsJson()) {
                $level = LevelModel::find($id);
                if ($level) {
                    $level->delete();
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
            return view('level.import');
        }
    
        public function import_ajax(Request $request)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'file_level' => ['required', 'mimes:xlsx', 'max:1024']
                ];
    
                $validator = Validator::make($request->all(), $rules);
    
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi Gagal',
                        'msgField' => $validator->errors()
                    ]);
                }
    
                $file = $request->file('file_level');
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
                                'level_kode' => $value['B'],
                                'level_nama' => $value['C'],
                                'created_at' => now(),
                            ];
                        }
                    }
    
                    if (count($insert) > 0) {
                        LevelModel::insertOrIgnore($insert);
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
            //ambil data user yang akan di export
            $level = LevelModel::select('level_id', 'level_kode', 'level_nama')
                ->orderBy('level_id')
                ->orderBy('level_kode')
                ->get();
            
            //load library excel
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Kode Level');
            $sheet->setCellValue('C1', 'Nama Level');

            $sheet->getStyle('A1:C1')->getFont()->setBold(true);    // bold header
            $no = 1;        // nomor data dimulai dari 1
            $baris = 2;     // baris data dimulai dari baris ke 2
            foreach ($level as $key => $value) {
                $sheet->setCellValue('A' . $baris, $value->level_id);
                $sheet->setCellValue('B' . $baris, $value->level_kode);
                $sheet->setCellValue('C' . $baris, $value->level_nama);
               
                $baris++;
                $no++;
            }
            
            foreach(range('A', 'FC') as $coloumID){
                $sheet->getColumnDimension($coloumID)->setAutoSize(true); // ambil nama kategori
            }
            
            $sheet->setTitle('Data Level'); // set title sheet
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data level ' . date('Y-m-d H:i:s') . '.xlsx';
    
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
            $level = LevelModel::select('level_id', 'level_kode', 'level_nama')
                ->orderBy('level_id')
                ->orderBy('level_kode')
                ->get();
            //use Barryvdh\DomPDF\Facade\PDF;
            $pdf = Pdf::loadView('level.export_pdf', ['level'=>$level]);
            $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
            $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
            
            $pdf->render();
            
            return $pdf->stream('Data Level ' . date('Y-m-d H:i:s') . '.pdf');
    
        }
    

}







