<?php

namespace App\Http\Controllers;

    use App\Models\KatagoriModel;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use Illuminate\Http\Request;
    use Yajra\DataTables\Facades\DataTables;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;
    use Barryvdh\DomPDF\Facade\Pdf;

    class KatagoriController extends Controller
    {
        public function index()
        {
            $breadcrumb = (object) [
                'title' => 'Daftar Katagori',
                'list' => ['Home', 'Katagori']
            ];

            $page = (object) [
                'title' => 'Daftar katagori dalam sistem'
            ];

            $activeMenu = 'katagori';

            // $katagori = KatagoriModel::select('katagori_id', 'katagori_kode', 'katagori_nama')->get();

            return view('katagori.index', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                // 'katagori' => $katagori
            ]);
        }

        public function list(Request $request)
        {
            $katagoris = KatagoriModel::select('katagori_id', 'katagori_kode', 'katagori_nama');

            return datatables()->of($katagoris)
                ->addIndexColumn() // Menambahkan kolom index/DT_RowIndex
                ->addColumn('aksi', function ($katagori) {
                    $btn = '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
                })

                ->rawColumns(['aksi']) // Memastikan kolom aksi dianggap sebagai HTML
                ->make(true);
        }

        public function create()
        {
            $breadcrumb = (object) [
                'title' => 'Tambah Katagori',
                'list' => ['Home', 'Katagori', 'Tambah']
            ];

            $page = (object) [
                'title' => 'Tambah katagori baru'
            ];

            // $katagori = KatagoriModel::all();
            $activeMenu = 'katagori';

            return view('katagori.katagoriCreate', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                // 'katagori' => $katagori,
                'activeMenu' => $activeMenu
            ]);
        }
        // Menyimpan data katagori baru
        public function store(Request $request)
        {
            $request->validate([
                'katagori_kode' => 'required|string|max:10|unique:m_katagori,katagori_kode',
                'katagori_nama' => 'required|string|max:100'
            ]);

            KatagoriModel::create([
                'katagori_kode' => $request->katagori_kode,
                'katagori_nama' => $request->katagori_nama
            ]);

            return redirect('/katagori')->with('success', 'Data katagori berhasil disimpan');
        }

        // Menampilkan detail katagori
        public function show(string $id)
        {
            $katagori = KatagoriModel::find($id);

            $breadcrumb = (object) [
                'title' => 'Detail Katagori',
                'list' => ['Home', 'Katagori', 'Detail']
            ];

            $page = (object) [
                'title' => 'Detail Katagori'
            ];

            $activeMenu = 'katagori'; // Set menu yang sedang aktif

            return view('katagori.show', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'katagori' => $katagori,
                'activeMenu' => $activeMenu
            ]);
        }

        // Menampilkan halaman form edit katagori
        public function edit(string $id)
        {
            $katagori = KatagoriModel::find($id);

            $breadcrumb = (object) [
                'title' => 'Edit Katagori',
                'list' => ['Home', 'Katagori', 'Edit']
            ];

            $page = (object) [
                'title' => 'Edit Katagori'
            ];

            $activeMenu = 'katagori'; // Set menu yang sedang aktif

            return view('katagori.edit', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'katagori' => $katagori,
                'activeMenu' => $activeMenu
            ]);
        }

        // Menyimpan perubahan data katagori
        public function update(Request $request, string $id)
        {
            $request->validate([
                'katagori_kode' => 'required|string|max:10|unique:m_katagori,katagori_kode,' . $id . ',katagori_id',
                'katagori_nama' => 'required|string|max:100'
            ]);

            KatagoriModel::find($id)->update([
                'katagori_kode' => $request->katagori_kode,
                'katagori_nama' => $request->katagori_nama
            ]);

            return redirect('/katagori')->with('success', 'Data katagori berhasil diubah');
        }

        // Menghapus data katagori
        public function destroy(string $id)
        {
            $katagori = KatagoriModel::find($id);

            if (!$katagori) {
                return redirect('/katagori')->with('error', 'Data katagori tidak ditemukan');
            }

            $katagori->delete();

            return redirect('/katagori')->with('success', 'Data katagori berhasil dihapus');
        }

        public function create_ajax()
        {
            return view('katagori.create_ajax');
        }

        public function store_ajax(Request $request)
        {
            // Cek apakah request berupa AJAX
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'katagori_kode' => 'required|string|max:10|unique:m_katagori,katagori_kode',
                    'katagori_nama' => 'required|string|max:100',
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
                KatagoriModel::create($request->all());

                // Response sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data katagori berhasil disimpan'
                ]);
            }

            // Jika bukan request AJAX, redirect ke halaman utama
            return redirect('/katagori');
        }

        public function edit_ajax(String $id)
        {
            $katagori = KatagoriModel::find($id);

            return view('katagori.edit_ajax', ['katagori' => $katagori]);
        }

        public function update_ajax(Request $request, $id)
        {
            // cek apakah request dari ajax
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'katagori_kode' => 'required|string|max:10|unique:m_katagori,katagori_kode',
                    'katagori_nama' => 'required|string|max:100',
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
                $check = KatagoriModel::find($id);
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
            return redirect('/katagori');
        }

        public function confirm_ajax(String $id)
        {
            $katagori = KatagoriModel::find($id);
            return view('katagori.confirm_ajax', ['katagori' => $katagori]);
        }

        public function delete_ajax(Request $request, $id)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $katagori = KatagoriModel::find($id);
                if ($katagori) {
                    $katagori->delete();
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
            return redirect('/katagori');
        }
        public function import()
    {
        return view('katagori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB 
                'file_katagori' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_katagori');  // ambil file dari request  
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
                            'katagori_kode' => $value['A'],
                            'katagori_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan 
                    KatagoriModel::insertOrIgnore($insert);
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
            $barang = KatagoriModel::select('katagori_id','katagori_kode','katagori_nama')
                        ->orderBy('katagori_id')
                        ->get();
    
            //load library excel
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Kode Katagori');
            $sheet->setCellValue('C1', 'Nama Katagori');
            
    
            $sheet->getStyle('A1:C1')->getFont()->setBold(true);
            
            $no =1;
            $baris = 2;
            foreach ($barang as $value) {
                $sheet->setCellValue('A'.$baris, $no++);
                $sheet->setCellValue('B'.$baris, $value->katagori_kode);
                $sheet->setCellValue('C'.$baris, $value->katagori_nama);
                $baris++;
                $no++;
            }
            foreach (range('A', 'C') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
    
            $sheet->setTitle('Data Katagori');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data Katagori '. date('Y-m-d H:i:s') .'.xlsx';
    
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
            $katagori = KatagoriModel::select('katagori_id','katagori_kode','katagori_nama')
                        ->orderBy('katagori_id')
                        ->get();
            $pdf = PDF::loadview('katagori.export_pdf', ['katagori' => $katagori]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->setOption("isRemoteEnabled", true);
            $pdf->render();
    
            return $pdf->stream('Data Katagori '.date('Y-m-d H:i:s').'.pdf');
        }
    }
