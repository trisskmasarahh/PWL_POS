<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KatagoriModel; // Perubahan nama model
use App\Models\LevelModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'barang';
        $breadcrumb = (object) [
            'title' => 'Data Barang',
            'list' => ['Home', 'Barang']
        ];

        
        $katagori = KatagoriModel::select('katagori_id', 
        'katagori_nama')->get();
        return view('barang.index', [
            'activeMenu'=>$activeMenu,
            'breadcrumb' => $breadcrumb,
            'katagori' => $katagori
        ]);
    }

    // Mengambil data barang dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        $barang = BarangModel::select(
            'barang_id',
            'barang_kode',
            'barang_nama',
            'harga_beli',
            'harga_jual',
            'katagori_id')->with('katagori');
            
        $katagori_id = $request->input('filter_katagori');
        if (!empty($katagori_id)) {
            $barang->where('katagori_id', $katagori_id);
        }
            return dataTables()->of($barang)
            ->addIndexColumn() // Menambahkan kolom index/DT_RowIndex
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // Memastikan kolom aksi dianggap sebagai HTML
            ->make(true);
    }
    public function show_ajax(string $id)
    {
         // Mengambil data 
        $barang = BarangModel::with('katagori')->find($id);
 
         // Return view dalam bentuk popup
        return view('barang.show_ajax', [
            'barang' => $barang
         ]);
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

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        $katagoris = KatagoriModel::all(); // Ambil data katagori untuk dropdown // Perubahan nama model

        return view('barang.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'katagoris' => $katagoris // Perubahan nama variabel
        ]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'katagori_id' => 'required|integer', // Perubahan nama kolom
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'katagori_id' => $request->katagori_id // Perubahan nama kolom
        ]);

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
 
         $activeMenu = 'barang'; // Set menu yang sedang aktif
 
         return view('barang.show', [
             'breadcrumb' => $breadcrumb,
             'page' => $page,
             'barang' => $barang,
            'activeMenu' => $activeMenu
         ]);
        }
    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $katagoris = KatagoriModel::all(); // Ambil data katagori untuk dropdown // Perubahan nama model

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'katagoris' => $katagoris, // Perubahan nama variabel
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'katagori_id' => 'required|integer', // Perubahan nama kolom
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::find($id)->update([
            'katagori_id' => $request->katagori_id, // Perubahan nama kolom
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);

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

    public function create_ajax()
    {
        $katagori = KatagoriModel::select('katagori_id', 'katagori_nama')->get();
        return  view('barang.create_ajax')->with('katagori', $katagori);
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'katagori_id' => ['required', 'integer', 'exists:m_katagori,katagori_id'],
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode'],
                'barang_nama' => ['required', 'string', 'max:100'],
                'harga_beli' => ['required', 'numeric'],
                'harga_jual' => ['required', 'numeric'],


            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // Status response, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // Pesan error validasi
                ]);
            }

            // Simpan data user
            BarangModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }

        redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                    'katagori_id' => ['required', 'integer', 'exists:m_katagori,katagori_id'],
                    'barang_kode' => [
                    'required',
                    'min:3',
                    'max:20',
                    'unique:m_barang,barang_kode,' . $id . ',barang_id'
                ],
                    'barang_nama' => ['required', 'string', 'max:100'],
                    'harga_beli' => ['required', 'numeric'],
                    'harga_jual' => ['required', 'numeric'],
            ];

            // validasi
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = BarangModel::find($id);
            if ($check) {

                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
}
        public function import()
        {
            return view('barang.import');
        }
        public function import_ajax(Request $request)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    // validasi file harus xlsx, max 1MB 
                    'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
                ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_barang');  // ambil file dari request  
        $reader = IOFactory::createReader('Xlsx');  // load reader file excel 
        $reader->setReadDataOnly(true);             // hanya membaca data 
        $spreadsheet = $reader->load($file->getRealPath()); // load file excel             
        $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif  
        $data = $sheet->toArray(null, false, true, true);   // ambil data excel 

        $insert = [];
        if (count($data) > 1) { // jika data lebih dari 1 baris                 
            foreach ($data as $baris => $value) { 
                if ($baris > 1) { // baris ke 1 adalah header, maka lewati 
                    $insert[] = [
                        'katagori_id' => $value['A'], // diubah dari kategori_id
                        'barang_kode' => $value['B'],
                        'barang_nama' => $value['C'],
                        'harga_beli' => $value['D'],
                        'harga_jual' => $value['E'],
                        'created_at' => now(),
                    ];
                }
            }
            if (count($insert) > 0) {
                // insert data ke database, jika data sudah ada, maka diabaikan 
                BarangModel::insertOrIgnore($insert);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
            
    }
        return redirect('/');
    
    }
    public function export_excel()
{
    $barang = BarangModel::select('katagori_id','barang_kode','barang_nama','harga_beli','harga_jual')
                ->orderBy('katagori_id')
                ->with('katagori')
                ->get();

    //load library excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Barang');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Harga Beli');
    $sheet->setCellValue('E1', 'Harga Jual');
    $sheet->setCellValue('F1', 'Katagori'); // Ubah dari "Kategori" menjadi "Katagori"

    $sheet->getStyle('A1:F1')->getFont()->setBold(true);
    
    $no = 1;
    $baris = 2;
    foreach ($barang as $value) {
        $sheet->setCellValue('A'.$baris, $no);
        $sheet->setCellValue('B'.$baris, $value->barang_kode);
        $sheet->setCellValue('C'.$baris, $value->barang_nama);
        $sheet->setCellValue('D'.$baris, $value->harga_beli);
        $sheet->setCellValue('E'.$baris, $value->harga_jual);
        $sheet->setCellValue('F'.$baris, $value->kategori->katagori_nama ?? '-'); // Antisipasi jika null
        $baris++;
        $no++;
    }

    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Barang');
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Barang '. date('Y-m-d H:i:s') .'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer->save('php://output');
    exit;
    }
    public function export_pdf()
    {
        set_time_limit(1000);
        $barang = BarangModel::select('katagori_id','barang_kode', 'barang_nama','harga_beli','harga_jual')
        ->orderBy('katagori_id')
        ->orderBy('barang_kode')
        ->with('katagori')
        ->get();
        $pdf = pdf::loadView('barang.export_pdf', ['barang'=> $barang]);
        $pdf->setPaper('A4', 'potrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

    return $pdf->stream('Data Barang '.date('Y-m-d H:i:s').'.pdf');
    }

}