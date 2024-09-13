<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Andi Pratama',
                'penjualan_kode' => 1,
                'penjualan_tanggal' => '2024-09-13 10:00:00',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Budi Santoso',
                'penjualan_kode' => 2,
                'penjualan_tanggal' => '2024-09-13 11:00:00',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 2, // Manager
                'pembeli' => 'Citra Dewi',
                'penjualan_kode' => 3,
                'penjualan_tanggal' => '2024-09-13 12:00:00',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Doni Rahmat',
                'penjualan_kode' => 4,
                'penjualan_tanggal' => '2024-09-13 13:00:00',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2, // Manager
                'pembeli' => 'Eka Putri',
                'penjualan_kode' => 5,
                'penjualan_tanggal' => '2024-09-13 14:00:00',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 1, // Administrator
                'pembeli' => 'Fajar Abdullah',
                'penjualan_kode' => 6,
                'penjualan_tanggal' => '2024-09-13 15:00:00',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Gina Maharani',
                'penjualan_kode' => 7,
                'penjualan_tanggal' => '2024-09-13 16:00:00',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2, // Manager
                'pembeli' => 'Hendra Wijaya',
                'penjualan_kode' => 8,
                'penjualan_tanggal' => '2024-09-13 17:00:00',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 1, // Administrator
                'pembeli' => 'Ika Sari',
                'penjualan_kode' => 9,
                'penjualan_tanggal' => '2024-09-13 18:00:00',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Joko Anwar',
                'penjualan_kode' => 10,
                'penjualan_tanggal' => '2024-09-13 19:00:00',
            ],
        ];
        
        DB::table('t_penjualan')->insert($data);
        
    }
}
