<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatagoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_katagori'; // Pastikan tabelnya sesuai dengan database
    protected $primaryKey = 'katagori_id';
    public $timestamps = false;

    protected $fillable = [
        'katagori_nama'
    ];

    // Relasi ke BarangModel
    public function barangs()
    {
        return $this->hasMany(BarangModel::class, 'katagori_id', 'katagori_id');
    }
}
