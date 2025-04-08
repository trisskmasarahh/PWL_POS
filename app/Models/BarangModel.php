<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Sesuai dengan tabel di database
    protected $primaryKey = 'barang_id';
    public $timestamps = false;

    // protected $fillable = [
    //     'katagori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'
    // ];
    protected $fillable = ['barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'stok', 'katagori_id'];

    // Relasi ke KatagoriModel
    public function katagori()
    {
        return $this->belongsTo(KatagoriModel::class, 'katagori_id', 'katagori_id');
    }
}
