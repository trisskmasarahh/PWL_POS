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
        $data=[
            [
                'penjualan_id' => '1',
                'user_id' => '3',
                'pembeli' => 'Keeling',
                'penjualan_kode' => 'PMJ001',
                'penjualan_tanggal' => '2024-03-03 10:00:00',
            ],
            [
                'penjualan_id' => '2',
                'user_id' => '3',
                'pembeli' => 'Nicolas',
                'penjualan_kode' => 'PMJ002',
                'penjualan_tanggal' => '2024-03-03 10:10:00',
            ],
            [
                'penjualan_id' => '3',
                'user_id' => '3',
                'pembeli' => 'Stoltenberg',
                'penjualan_kode' => 'PMJ003',
                'penjualan_tanggal' => '2024-03-03 10:20:00',
            ],
            [
                'penjualan_id' => '4',
                'user_id' => '3',
                'pembeli' => 'Raynor',
                'penjualan_kode' => 'PMJ004',
                'penjualan_tanggal' => '2024-03-03 10:30:00',
            ],
            [
                'penjualan_id' => '5',
                'user_id' => '3',
                'pembeli' => 'Graham',
                'penjualan_kode' => 'PMJ005',
                'penjualan_tanggal' => '2024-03-03 10:40:00',
            ],
            [
                'penjualan_id' => '6',
                'user_id' => '3',
                'pembeli' => 'Legros',
                'penjualan_kode' => 'PMJ006',
                'penjualan_tanggal' => '2024-03-03 10:50:00',
            ],
            [
                'penjualan_id' => '7',
                'user_id' => '3',
                'pembeli' => 'Zemlak',
                'penjualan_kode' => 'PMJ007',
                'penjualan_tanggal' => '2024-03-03 11:00:00',
            ],
            [
                'penjualan_id' => '8',
                'user_id' => '3',
                'pembeli' => 'Labadie',
                'penjualan_kode' => 'PMJ008',
                'penjualan_tanggal' => '2024-03-03 11:10:00',
            ],
            [
                'penjualan_id' => '9',
                'user_id' => '3',
                'pembeli' => 'Mann',
                'penjualan_kode' => 'PMJ009',
                'penjualan_tanggal' => '2024-03-03 11:20:00',
            ],
            [
                'penjualan_id' => '10',
                'user_id' => '3',
                'pembeli' => 'Mueller',
                'penjualan_kode' => 'PMJ010',
                'penjualan_tanggal' => '2024-03-03 11:30:00',
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
