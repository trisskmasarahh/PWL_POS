<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KatagoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'katagori_id' => '1',
                'katagori_kode' => 'MAKANAN',
                'katagori_nama' => 'Makanan'
            ],
            [
                'katagori_id' => '2',
                'katagori_kode' => 'MINUMAN',
                'katagori_nama' => 'Minuman'
            ],
            [
                'katagori_id' => '3',
                'katagori_kode' => 'SNACK',
                'katagori_nama' => 'Snack'
            ],
            [
                'katagori_id' => '4',
                'katagori_kode' => 'ICECREAM',
                'katagori_nama' => 'Ice Cream'
            ],
            [
                'katagori_id' => '5',
                'katagori_kode' => 'EXTRA',
                'katagori_nama' => 'Extra',
            ],
        ];
        DB::table('m_katagori')->insert($data);
    }
}
