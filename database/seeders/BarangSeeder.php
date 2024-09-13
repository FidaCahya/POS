<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $data = [
            // Barang dari Pt. Pangan Merdeka (Kategori Makanan dan Minuman)
            [
                'barang_id' => 1,
                'barang_kode'=> 1,
                'kategori_id' => 1, // Makanan
                'barang_nama' => 'Roti Tawar',
                'harga_beli' => 5000,
                'harga_jual' => 7000,
            ],
            [
                'barang_id' => 2,
                'barang_kode'=> 2,
                'kategori_id' => 1, // Makanan
                'barang_nama' => 'Nasi Goreng',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
            ],
            [
                'barang_id' => 3,
                'barang_kode'=> 3,
                'kategori_id' => 2, // Minuman
                'barang_nama' => 'Teh Manis',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],
            [
                'barang_id' => 4,
                'barang_kode'=> 4,
                'kategori_id' => 2, // Minuman
                'barang_nama' => 'Jus Jeruk',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
            ],
            [
                'barang_id' => 5,
                'barang_kode'=> 5,
                'kategori_id' => 1, // Makanan
                'barang_nama' => 'Burger',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
            ],
        
            // Barang dari PT. Elektronik Global (Kategori Elektronik)
            [
                'barang_id' => 6,
                'barang_kode'=> 6,
                'kategori_id' => 3, // Elektronik
                'barang_nama' => 'Laptop Asus',
                'harga_beli' => 5000000,
                'harga_jual' => 5500000,
            ],
            [
                'barang_id' => 7,
                'barang_kode'=> 7,
                'kategori_id' => 3, // Elektronik
                'barang_nama' => 'Smartphone Samsung',
                'harga_beli' => 3000000,
                'harga_jual' => 3500000,
            ],
            [
                'barang_id' => 8,
                'barang_kode'=> 8,
                'kategori_id' => 3, // Elektronik
                'barang_nama' => 'Mouse Logitech',
                'harga_beli' => 100000,
                'harga_jual' => 150000,
            ],
            [
                'barang_id' => 9,
                'barang_kode'=> 9,
                'kategori_id' => 3, // Elektronik
                'barang_nama' => 'Headset Sony',
                'harga_beli' => 500000,
                'harga_jual' => 600000,
            ],
            [
                'barang_id' => 10,
                'barang_kode'=> 10,
                'kategori_id' => 3, // Elektronik
                'barang_nama' => 'Charger HP',
                'harga_beli' => 50000,
                'harga_jual' => 75000,
            ],
        
            // Barang dari PT. Lula Berkain (Kategori Pakaian)
            [
                'barang_id' => 11,
                'barang_kode'=> 11,
                'kategori_id' => 4, // Pakaian
                'barang_nama' => 'Kaos Pria',
                'harga_beli' => 40000,
                'harga_jual' => 60000,
            ],
            [
                'barang_id' => 12,
                'barang_kode'=> 12,
                'kategori_id' => 4, // Pakaian
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => 80000,
                'harga_jual' => 120000,
            ],
            [
                'barang_id' => 13,
                'barang_kode'=> 13,
                'kategori_id' => 4, // Pakaian
                'barang_nama' => 'Kemeja Wanita',
                'harga_beli' => 70000,
                'harga_jual' => 100000,
            ],
            [
                'barang_id' => 14,
                'barang_kode'=> 14,
                'kategori_id' => 4, // Pakaian
                'barang_nama' => 'Sepatu Anak',
                'harga_beli' => 50000,
                'harga_jual' => 80000,
            ],
            [
                'barang_id' => 15,
                'barang_kode'=> 15,
                'kategori_id' => 4, // Pakaian
                'barang_nama' => 'Aksesoris Wanita',
                'harga_beli' => 20000,
                'harga_jual' => 35000,
            ],
        ];
        DB::table('m_barang')->insert($data);
        
    }
}
