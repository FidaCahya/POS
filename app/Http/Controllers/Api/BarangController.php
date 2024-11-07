<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;
use Monolog\Barang;

class BarangController extends Controller
{
    public function index(){
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        // $barang = BarangModel::create($request->all());
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|unique:m_barang,barang_kode|max:10', // Unique constraint for barang_kode
            'barang_nama' => 'required|string|max:100', // Validate barang_nama
            'harga_beli'  => 'required|integer', // Validate harga_beli
            'harga_jual'  => 'required|integer', // Validate harga_jual
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id', // Validate kategori_id
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'        
        ]);
        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // Create user
        $image =  $request->file('image');
        
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'nama' => $request->nama,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image' => $image->hashName(),
        ]);

        return response()->json($barang, 201);
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',

        ]);
    }
}
