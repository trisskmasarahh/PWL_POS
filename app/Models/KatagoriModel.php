<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatagoriModel extends Model
{
    protected $table = 'm_katagori'; // Nama tabel di database
    protected $primaryKey = 'katagori_id'; // Primary key tabel

    protected $fillable = ['katagori_id', 'katagori_kode', 'katagori_nama'];

    public function barang()
    {
        return $this->hasMany(BarangModel::class, 'katagori_id', 'katagori_id');
    }
}