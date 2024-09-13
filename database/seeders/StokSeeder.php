<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Stok dari Pt. Pangan Merdeka (Kategori Makanan dan Minuman, User ID 3)
            [
                'stok_id' => 1,
                'supplier_id' => 1,
                'barang_id' => 1, // Roti Tawar
                'user_id' => 3,
                'stok_tanggal' => '2024-09-13 10:00:00',
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 2,
                'supplier_id' => 1,
                'barang_id' => 2, // Nasi Goreng
                'user_id' => 3,
                'stok_tanggal' => '2024-09-13 11:00:00',
                'stok_jumlah' => 50,
            ],
            [
                'stok_id' => 3,
                'supplier_id' => 1,
                'barang_id' => 3, // Teh Manis
                'user_id' => 3,
                'stok_tanggal' => '2024-09-13 12:00:00',
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 4,
                'supplier_id' => 1,
                'barang_id' => 4, // Jus Jeruk
                'user_id' => 3,
                'stok_tanggal' => '2024-09-13 13:00:00',
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 5,
                'supplier_id' => 1,
                'barang_id' => 5, // Burger
                'user_id' => 3,
                'stok_tanggal' => '2024-09-13 14:00:00',
                'stok_jumlah' => 80,
            ],
        
            // Stok dari PT. Elektronik Global (Kategori Elektronik, User ID 2)
            [
                'stok_id' => 6,
                'supplier_id' => 2,
                'barang_id' => 6, // Laptop Asus
                'user_id' => 2,
                'stok_tanggal' => '2024-09-13 15:00:00',
                'stok_jumlah' => 10,
            ],
            [
                'stok_id' => 7,
                'supplier_id' => 2,
                'barang_id' => 7, // Smartphone Samsung
                'user_id' => 2,
                'stok_tanggal' => '2024-09-13 16:00:00',
                'stok_jumlah' => 20,
            ],
            [
                'stok_id' => 8,
                'supplier_id' => 2,
                'barang_id' => 8, // Mouse Logitech
                'user_id' => 2,
                'stok_tanggal' => '2024-09-13 17:00:00',
                'stok_jumlah' => 50,
            ],
            [
                'stok_id' => 9,
                'supplier_id' => 2,
                'barang_id' => 9, // Headset Sony
                'user_id' => 2,
                'stok_tanggal' => '2024-09-13 18:00:00',
                'stok_jumlah' => 30,
            ],
            [
                'stok_id' => 10,
                'supplier_id' => 2,
                'barang_id' => 10, // Charger HP
                'user_id' => 2,
                'stok_tanggal' => '2024-09-13 19:00:00',
                'stok_jumlah' => 100,
            ],
        
            // Stok dari PT. Lula Berkain (Kategori Pakaian, User ID 1)
            [
                'stok_id' => 11,
                'supplier_id' => 3,
                'barang_id' => 11, // Kaos Pria
                'user_id' => 1,
                'stok_tanggal' => '2024-09-13 20:00:00',
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 12,
                'supplier_id' => 3,
                'barang_id' => 12, // Celana Jeans
                'user_id' => 1,
                'stok_tanggal' => '2024-09-13 21:00:00',
                'stok_jumlah' => 70,
            ],
            [
                'stok_id' => 13,
                'supplier_id' => 3,
                'barang_id' => 13, // Kemeja Wanita
                'user_id' => 1,
                'stok_tanggal' => '2024-09-13 22:00:00',
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 14,
                'supplier_id' => 3,
                'barang_id' => 14, // Sepatu Anak
                'user_id' => 1,
                'stok_tanggal' => '2024-09-13 23:00:00',
                'stok_jumlah' => 60,
            ],
            [
                'stok_id' => 15,
                'supplier_id' => 3,
                'barang_id' => 15, // Aksesoris Wanita
                'user_id' => 1,
                'stok_tanggal' => '2024-09-14 00:00:00',
                'stok_jumlah' => 200,
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}
