<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KatagoriModel; // Sudah sesuai dengan nama model yang benar

class BarangController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title'=> 'Daftar Barang',
            'list'=> ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar Barang'
        ];

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Mengambil data barang dalam bentuk JSON untuk DataTables
    public function list(Request $request)
{
    $barangs = BarangModel::with('katagori') // Memuat relasi ke kategori
        ->select('barang_id', 'katagori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');

    return datatables()->of($barangs)
        ->addIndexColumn()
        ->addColumn('katagori_nama', function ($barang) { 
            return $barang->katagori ? $barang->katagori->katagori_nama : '-';
        })
        ->addColumn('aksi', function ($barang) {
            return '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> '
                . '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> '
                . '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                . csrf_field() . method_field('DELETE')
                . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>'
                . '</form>';
        })
        ->rawColumns(['aksi'])
        ->make(true);

}

    // Menampilkan halaman form tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Barang Baru'
        ];
        $activeMenu = 'barang';

        $katagoris = KatagoriModel::all(); // Ambil data kategori untuk dropdown

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'katagoris'));
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'katagori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::create($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    // Menampilkan detail barang
    public function show(string $id)
    {
        $barang = BarangModel::with('katagori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Barang'
        ];
        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $katagoris = KatagoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Barang'
        ];
        $activeMenu = 'barang';

        return view('barang.edit', compact('breadcrumb', 'page', 'barang', 'katagoris', 'activeMenu'));
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'katagori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::find($id)->update($request->all());

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    // Menghapus data barang
    public function destroy(string $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $barang->delete();

        return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
    }
}
