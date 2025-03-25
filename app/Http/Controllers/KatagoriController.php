<?php

namespace App\Http\Controllers;

use App\Models\KatagoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        $katagori = KatagoriModel::select('katagori_id', 'katagori_kode', 'katagori_nama')->get();

        return view('katagori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'katagori' => $katagori
        ]);
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

        $katagori = KatagoriModel::all();
        $activeMenu = 'katagori';

        return view('katagori.katagoriCreate', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'katagori' => $katagori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $katagori = KatagoriModel::select('katagori_id', 'katagori_kode', 'katagori_nama');

        if ($request->katagori_id) {
            $katagori->where('katagori_id', $request->katagori_id);
        }

        return DataTables::of($katagori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($katagori) {
                $btn = '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/katagori/' . $katagori->katagori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
