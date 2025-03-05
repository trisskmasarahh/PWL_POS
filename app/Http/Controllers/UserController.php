<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{ 
    public function index()
    {

        $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);

        // $user = UserModel::find(1);
        // $user = UserModel::firstWhere('level_id', 1)->first();
        // $user = UserModel::findOr(1, ['username', 'nama'],function (){
        //     abort(404);
        // });
        // $user = UserModel::findOr(20, ['username', 'nama'],function (){
        //     abort(404);
        // });
        // $user = UserModel::findOrFail(1);
    }
}
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
