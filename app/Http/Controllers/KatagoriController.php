<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatagoriController extends Controller
{
    public function index()
    {
        // $data = [
        //     'katagori_kode' => 'SNK',
        //     'katagori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];

        // DB::table('m_katagori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_katagori')->where('katagori_kode', 'SNK')->update(['katagori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

//         $row = DB::table('m_katagori')->where('katagori_kode', 'SNK')->delete();
// return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';
        $data = DB::table('m_katagori')->get();
        return view('katagori', ['data' => $data]);
    }
}
