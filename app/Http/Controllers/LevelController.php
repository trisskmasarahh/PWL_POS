<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\LevelModel;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;
    class LevelController extends Controller
    {
        // Menampilkan halaman awal level
        public function index()
        {
            $breadcrumb = (object) [
                'title' => 'Daftar Level',
                'list' => ['Home', 'Level']
            ];

            $page = (object) [
                'title' => 'Daftar level yang terdaftar dalam sistem'
            ];

            $activeMenu = 'level'; // Set menu yang sedang aktif

            return view('level.index', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu
            ]);
        }
        public function list(Request $request)
        {
            $level = LevelModel::select('level_id', 'level_kode', 'level_nama');
    
            return DataTables::of($level)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default: DT_RowIndex)
            ->addColumn('aksi', function ($level) {
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id .
                '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id .
                '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id .
                '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

            return $btn;
        })
        ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
                ->make(true);
        }
        // Menampilkan halaman form tambah level
        public function create()
        {
            $breadcrumb = (object) [
                'title' => 'Tambah Level',
                'list' => ['Home', 'Level', 'Tambah']
            ];

            $page = (object) [
                'title' => 'Tambah level baru'
            ];

            $activeMenu = 'level'; // set menu yang sedang aktif

            return view('level.create', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu
            ]);
        }

        // Menyimpan data level baru
        public function store(Request $request)
        {
            $request->validate([
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode', // Kode level harus unik
                'level_nama' => 'required|string|max:100', // Nama level wajib diisi dengan maksimal 100 karakter
            ]);

            LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);

            return redirect('/level')->with('success', 'Data level berhasil disimpan');
        }

        // Menampilkan detail level
        public function show($id)
        {
            $level = LevelModel::find($id);

            if (!$level) {
                return redirect('/level')->with('error', 'Level tidak ditemukan');
            }

            $breadcrumb = (object) [
                'title' => 'Detail Level',
                'list' => ['Home', 'Level', 'Detail']
            ];

            $page = (object) [
                'title' => 'Detail level'
            ];

            $activeMenu = 'level'; // Set menu yang sedang aktif

            return view('level.levelShow', [
                'level' => $level,
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu
            ]);
        }

        // Menampilkan halaman form edit level
        public function edit(string $id)
        {
            $level = LevelModel::find($id);

            $breadcrumb = (object) [
                "title" => "Edit Level",
                "list" => ['Home', 'Level', 'Edit']
            ];

            $page = (object) [
                "title" => "Edit level"
            ];

            $activeMenu = 'level'; // set menu yang sedang aktif

            return view('level.edit', [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'level' => $level,
                'activeMenu' => $activeMenu
            ]);
        }

        // Menyimpan perubahan data level
        public function update(Request $request, string $id)
        {
            $request->validate([
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                // kode level harus diisi, berupa string, dan bernilai unik kecuali untuk level dengan id yang sedang diedit
                'level_nama' => 'required|string|max:100', // nama level harus diisi, berupa string, dan maksimal 100 karakter
            ]);

            LevelModel::find($id)->update([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama,
            ]);

            return redirect('/level')->with('success', 'Data level berhasil diubah');
        }

        // Menghapus data level
            public function destroy(string $id)
            {
                $level = LevelModel::find($id);
        
                if (!$level) {
                    return redirect('/level')->with('error', 'Data level tidak ditemukan');
                }
        
                $level->delete();
        
                return redirect('/level')->with('success', 'Data level berhasil dihapus');
            }

        // public function destroy(string $id)
        // {
        //     $level = LevelModel::find($id);
        //     if (!$level) {      //untuk mengecek apakah data level yang akan dihapus ada atau tidak
        //         return redirect('/level')->with('error', 'Data level tidak ditemukan');
        //     }
        //     // try {
        //     //     LevelModel::destroy($id);
        //         return redirect('/level')->with('success', 'Data level berhasil dihapus');
        //     // } catch (\Illuminate\Database\QueryException $e) {
        //         //jika terjadi error ketika menghapus data, maka tampilkan pesan error dan redirect ke halaman level
        //         return redirect('/level')->with('error', 'Data level sedang digunakan');
        //     }
        // }

        public function create_ajax()
        {
            return view('level.create_ajax');
        }

        public function store_ajax(Request $request)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                    'level_nama' => 'required|string|max:100'
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi Gagal',
                        'msgField' => $validator->errors(),
                    ]);
                }

                LevelModel::create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil disimpan'
                ]);
            }
            return redirect('/');
        }



        public function edit_ajax(String $id)
        {
            $level = LevelModel::find($id);
    
            return view('level.edit_ajax', ['level' => $level]);
        }
        public function update_ajax(Request $request, $id)
        {
            // cek apakah request dari ajax
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                    'level_nama' => 'required|string|max:100',
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
                $check = LevelModel::find($id);
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
            return redirect('/level');
        }
    
        public function confirm_ajax(String $id)
        {
            $level = LevelModel::find($id);
            return view('level.confirm_ajax', ['level' => $level]);
        }
    
        public function delete_ajax(Request $request, $id)
        {
            if ($request->ajax() || $request->wantsJson()) {
                $level = LevelModel::find($id);
                if ($level) {
                    $level->delete();
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
            return redirect('/level');
        }
    }