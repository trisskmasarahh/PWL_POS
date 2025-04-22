<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{ 
    
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif
        $level = LevelModel::all();//ambil data level u/filter
        return view('user.index', ['breadcrumb' => $breadcrumb, 
        'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    //Ambil data user dalam bentuk json untuk datatables

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');
    
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function show_ajax(string $id)
{
     // Mengambil data user berdasarkan ID dengan relasi level
    $user = UserModel::with('level')->find($id);

     // Return view dalam bentuk popup
    return view('user.show_ajax', [
    'user' => $user
    ]);

    }
        // Menampilkan halaman form tambah user
        public function create()
        {
            $breadcrumb = (object) [
                'title' => 'Tambah User',
                'list' => ['Home', 'User', 'Tambah']
            ];

            $page = (object) [
                'title' => 'Tambah user baru'
            ];

            $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
            $activeMenu = 'user'; // set menu yang sedang aktif

            return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
        }
        // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
                'level_id' => $request->level_id
        ]);

            return redirect('/user')->with('success', 'Data user berhasil disimpan');
        }
        // Menampilkan detail user
        public function show(string $id)
        {
            $user = UserModel::with('level')->find($id);

            $breadcrumb = (object) [
                'title' => 'Detail User',
                'list' => ['Home', 'User', 'Detail']
            ];

            $page = (object) [
                'title' => 'Detail user'
            ];

            $activeMenu = 'user'; // set menu yang sedang aktif

            return view('user.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
        }
        
        // Menampilkan halaman form edit user
        public function edit(string $id)
        {
            $user = UserModel::find($id);
            $level = LevelModel::all();

            $breadcrumb = (object) [
                'title' => 'Edit User',
                'list' => ['Home', 'User', 'Edit']
            ];

            $page = (object) [
                'title' => 'Edit user'
            ];

            $activeMenu = 'user'; // set menu yang sedang aktif

            return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
        }

        // Menyimpan perubahan data user
            public function update(Request $request, string $id)
            {
                $request->validate([
                    // username harus diisi, berupa string, minimal 3 karakter,
                    // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
                    'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
                    'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
                    'password' => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
                    'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
                ]);

                UserModel::find($id)->update([
                    'username' => $request->username,
                    'nama' => $request->nama,
                    'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'level_id' => $request->level_id
                ]);

                return redirect('/user')->with('success', 'Data user berhasil diubah');
            }
            // Menghapus data user
            public function destroy(string $id)
            {
                $check = UserModel::find($id); // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
                if (!$check) {
                    return redirect('/user')->with('error', 'Data user tidak ditemukan');
                }

                try {
                    UserModel::destroy($id); // Hapus data user
                    return redirect('/user')->with('success', 'Data user berhasil dihapus');
                } catch (\Illuminate\Database\QueryException $e) {
                    // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
                    return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
                }
            }
            //tambah fungsi create_ ajax
            public function create_ajax(){
                $level = LevelModel::select('level_id', 'level_nama')->get();
        
                return view('user.create_ajax')->with('level', $level);
            }
            public function store_ajax ( Request $request ) {
                // cek apakah request berupa ajax
                if ( $request->ajax() || $request->wantsJson() ) {
            
                    $rules = [
                        'level_id' => 'required|integer',
                        'username' => 'required|string|min:3|unique:m_user,username',
                        'nama' => 'required|string|max:100',
                        'password' => 'required|min:6'
                    ];
            
                    // use Illuminate\Support\Facades\Validator;
                    $validator = Validator::make($request->all(), $rules);
            
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false, // response status, false: error/gagal, true: berhasil
                            'message' => 'Validasi Gagal',
                            'msgField' => $validator->errors(), // pesan error validasi
                        ]);
                    }
            
                    UserModel::create($request->all());
            
                    return response()->json([
                        'status' => true,
                        'message' => 'Data user berhasil disimpan'
                    ]);
                }
            
                redirect('/');
            }
            public function edit_ajax(string $id)
            {
                $user = UserModel::find($id);
                $level = LevelModel::select('level_id', 'level_nama')->get();
        
                return view('users.edit_ajax', ['user' => $user, 'level' => $level]);
            }
        
            public function update_ajax(Request $request, $id)
            {
                // Cek apakah request berasal dari AJAX
                if ($request->ajax() || $request->wantsJson()) {
                    $rules = [
                        'level_id' => 'required|integer',
                        'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                        'nama' => 'required|max:100',
                        'password' => 'nullable|min:6|max:20'
                    ];
        
                    // Validasi input
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false, // Respon JSON, false berarti gagal
                            'message' => 'Validasi gagal.',
                            'msgField' => $validator->errors() // Menampilkan field yang error
                        ]);
                    }
        
                    // Cek apakah user dengan ID tersebut ada
                    $user = UserModel::find($id);
                    if ($user) {
                        // Jika password tidak diisi, hapus dari request agar tidak terupdate
                        if (!$request->filled('password')) {
                            $request->request->remove('password');
                        }
        
                        $user->update($request->all());
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
            public function confirm_ajax(string $id){
                $user = UserModel::find($id);
                return view('users.confirm_ajax', ['user' => $user]);
            }
        
            public function delete_ajax(Request $request, $id)
            {
                // cek apakah request dari ajax
                if ($request->ajax() || $request->wantsJson()) {
                    $user = UserModel::find($id);
        
                    if ($user) {
                        $user->delete();
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
                return view('user.import');
            }
            public function import_ajax(Request $request)
            {
                if ($request->ajax() || $request->wantsJson()) {
                    $rules = [
                        // validasi file harus xls atau xlsx, max 1MB 
                        'file_user' => ['required', 'mimes:xlsx', 'max:1024']
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Validasi Gagal',
                            'msgField' => $validator->errors()
                        ]);
                    }
                    $file = $request->file('file_user');  // ambil file dari request  
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
                                    'user_id' => $value['A'],
                                    'username' => $value['B'],
                                    'nama' => $value['C'],
                                    'password' => $value['D'],
                                    'created_at' => now(),
                                ];
                            }
                        }
                        if (count($insert) > 0) {
                            // insert data ke database, jika data sudah ada, maka diabaikan 
                            UserModel::insertOrIgnore($insert);
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
            $user = UserModel::select('level_id','username','nama','password')
                        ->orderBy('level_id')
                        ->with('level')
                        ->get();
    
            //load library excel
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Username');
            $sheet->setCellValue('C1', 'Nama');
            $sheet->setCellValue('D1', 'Password');
    
            $sheet->getStyle('A1:D1')->getFont()->setBold(true);
            
            $no =1;
            $baris = 2;
            foreach ($user as $value) {
                $sheet->setCellValue('A'.$baris, $no++);
                $sheet->setCellValue('B'.$baris, $value->username);
                $sheet->setCellValue('C'.$baris, $value->name);
                $sheet->setCellValue('D'.$baris, $value->password);
                $baris++;
                $no++;
            }
            foreach (range('A', 'D') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
    
            $sheet->setTitle('Data User');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data User '. date('Y-m-d H:i:s') .'.xlsx';
    
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
            $user = UserModel::select('user_id','username','nama','password')
                        ->orderBy('user_id')
                        ->orderBy('username')
                        ->with('level')
                        ->get();
            $pdf = PDF::loadview('user.export_pdf', ['user' => $user]);
            $pdf->setPaper('A4', 'potrait');
            $pdf->setOption("isRemoteEnabled", true);
            $pdf->render();
    
            return $pdf->stream('Data User '.date('Y-m-d H:i:s').'.pdf');
        }
}
        // $user = UserModel::with('level')->get();
        // return view('user', ['data' => $user]);

        // $user = UserModel::with('level')->get();
        // dd($user);
        // return view('user', ['data'=> $user]);
    // }
    // public function tambah()
    // {
    //     return view('user_tambah');
    // }
    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id'=> $request->level_id
    //     ]);
    //     return redirect('/user');
    // }
    // public function ubah($id)
    // {
    //     $user = UserModel ::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama= $request->nama;
    //     $user->password= Hash::make('$request->password');
    //     $user->Level_id = $request->level_id;

    //     $user->save();
    //     return redirect('/user');
    // }
    // public function hapus($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //    return redirect('/user');
    

    
    

        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // $user = UserModel::create(
        // $user = UserModel::all();
        // return view('user', ['data'=> $user]);
//     }
// }
            // [
            //     // 'username' => 'manager55',
            //     // 'nama' =>'Manager55',
            //     // 'password' => Hash::make('12345'),
            //     // 'level_id'=> 2 ,
            //     'username' => 'manager11',
            //     'nama' =>'Manager11',
            //     'password' => Hash::make('12345'),
            //     'level_id'=> 2 ,
            // ]);
            // // $user->username= 'manager56';
            // $user->username= 'manager12';

            // $user->isDirty();//true
            // $user->isDirty('username');//true
            // $user->isDirty('nama'); // false
            // $user->isDirty(['nama', 'username']);//true

            // $user->isClean(); // false
            // $user->isClean('username'); // false
            // $user->isClean('nama'); // true
            // $user->isClean(['nama', 'username']);//false

            // $user->save();
            // $user->wasChanged();
            // $user->wasChanged('username');
            // $user->wasChanged(['username', 'level_id']);
            // $user->wasChanged('nama');
            // dd($user->wasChanged(['nama', 'username']));

            // $user->isDirty(); // false
            // $user->isClean(); // true

            // dd($user->isDirty());
//     }
// }
            
        // return view('user', ['data' => $user]);

        // $user = UserModel::find(1);
        // $user = UserModel::firstWhere('level_id', 1)->first();
        // $user = UserModel::findOr(1, ['username', 'nama'],function (){
        //     abort(404);
        // });
        // $user = UserModel::findOr(20, ['username', 'nama'],function (){
        //     abort(404);
        // });
        // $user = UserModel::findOrFail(1);
    

        // $data =[
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password'=> Hash::make('123456')
        // ];

        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data'=> $user]);

        // tambah data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); // update data user

        // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    
        // tambah data user dengan Eloquent Model
    //     $data = [
    //         'username' => 'customer-1',
    //         'nama' => 'Pelanggan',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 4
    //     ];
    //     UserModel::insert($data); // tambahkan data ke tabel m_user

    //     // coba akses model UserModel
    //     $user = UserModel::all(); // ambil semua data dari tabel m_user
    //     return view('user', ['data' => $user]);
    // }
    // public function index(){
    // $user =UserModel::all();
    // return view('user', ['data'=>$user]);
    // }
