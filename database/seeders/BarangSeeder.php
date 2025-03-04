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
            [
                'barang_id' => '1',
                'katagori_id' => '1',
                'barang_kode' => 'MKN001',
                'barang_nama' => 'Bakso',
                'harga_beli' => '10000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => '2',
                'katagori_id' => '1',
                'barang_kode' => 'MKN002',
                'barang_nama' => 'Mie Ayam',
                'harga_beli' => '10000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => '3',
                'katagori_id' => '2',
                'barang_kode' => 'MNM001',
                'barang_nama' => 'Es Teh',
                'harga_beli' => '3000',
                'harga_jual' => '5000',
            ],
            [
                'barang_id' => '4',
                'katagori_id' => '2',
                'barang_kode' => 'MNM002',
                'barang_nama' => 'Es Jeruk',
                'harga_beli' => '5000',
                'harga_jual' => '8000',
            ],
            [
                'barang_id' => '5',
                'katagori_id' => '3',
                'barang_kode' => 'SNC001',
                'barang_nama' => 'Siomay',
                'harga_beli' => '8000',
                'harga_jual' => '10000',
            ],
            [
                'barang_id' => '6',
                'katagori_id' => '3',
                'barang_kode' => 'SNC002',
                'barang_nama' => 'Sosis',
                'harga_beli' => '8000',
                'harga_jual' => '10000',
            ],
            [
                'barang_id' => '7',
                'katagori_id' => '4',
                'barang_kode' => 'ICE001',
                'barang_nama' => 'Straberry Ice Cream',
                'harga_beli' => '8000',
                'harga_jual' => '10000',
            ],
            [
                'barang_id' => '8',
                'katagori_id' => '4',
                'barang_kode' => 'ICE002',
                'barang_nama' => 'Mango Ice Cream',
                'harga_beli' => '8000',
                'harga_jual' => '10000',
            ],
            [
                'barang_id' => '9',
                'katagori_id' => '5',
                'barang_kode' => 'EXT001',
                'barang_nama' => 'Pentol',
                'harga_beli' => '500',
                'harga_jual' => '1000',
            ],
            [
                'barang_id' => '10',
                'katagori_id' => '5',
                'barang_kode' => 'EXT002',
                'barang_nama' => 'Pangsit',
                'harga_beli' => '500',
                'harga_jual' => '1000',
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
