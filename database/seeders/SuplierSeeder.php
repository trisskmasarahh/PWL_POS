<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supliers = [
            ['nama_suplier' => 'PT Terang Palu', 'kontak' => '082123456789', 'alamat' => 'Jl. Melati No. 10, Makassar'],
            ['nama_suplier' => 'Teko Lancar Jaya', 'kontak' => '082234567890', 'alamat' => 'Jl. Anggrek No. 11, Balikpapan'],
            ['nama_suplier' => 'UD Makmur Bersama', 'kontak' => '082345678901', 'alamat' => 'Jl. Pahlawan No. 12, Pontianak'],
            ['nama_suplier' => 'PT Jaya Abadi', 'kontak' => '082456789012', 'alamat' => 'Jl. Merapi No. 13, Manado'],
            ['nama_suplier' => 'CV Sukses Mandiri', 'kontak' => '082567890123', 'alamat' => 'Jl. Cemara No. 14, Padang'],
            ['nama_suplier' => 'Toko Amanah', 'kontak' => '082678901234', 'alamat' => 'Jl. Teratai No. 15, Samarinda'],
            ['nama_suplier' => 'UD Bintang Terang', 'kontak' => '082789012345', 'alamat' => 'Jl. Melodi No. 16, Pekanbaru'],
            ['nama_suplier' => 'PT Harapan Mulia', 'kontak' => '082890123456', 'alamat' => 'Jl. Mawar No. 17, Medan'],
            ['nama_suplier' => 'CV Karya Indah', 'kontak' => '082901234567', 'alamat' => 'Jl. Sehat No. 18, Banda Aceh'],
            ['nama_suplier' => 'Toko Sinar Jaya', 'kontak' => '083012345678', 'alamat' => 'Jl. Damai No. 19, Banjarmasin'],
            ['nama_suplier' => 'UD Lancar Rejeki', 'kontak' => '083123456789', 'alamat' => 'Jl. Cemara No. 20, Jayapura'],
        ];

        DB::table('m_suplier')->insert($supliers);
    }
}
