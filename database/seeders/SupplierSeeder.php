<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'supplier_id'=> 1,
                'supplier_kode'=> 1 ,
                'supplier_nama'=>'Pt.Pangan Merdeka',
                'supplier_alamat'=>'Jl. Raya Bogor No. 123, Jakarta',
            ],
            [
                'supplier_id'=> 2,
                'supplier_kode'=>2 ,
                'supplier_nama'=>'PT. Elektronik Global',
                'supplier_alamat'=>'Jl. Sudirman No. 78, Surabaya',
            ],
            [
                'supplier_id'=> 3,
                'supplier_kode'=> 3,
                'supplier_nama'=>'PT. Lula Berkain',
                'supplier_alamat'=>'Jl. Dewi Sartika No. 15, Depok',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
