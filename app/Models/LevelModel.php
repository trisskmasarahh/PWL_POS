<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level'; // Nama tabel di database
    protected $primaryKey = 'level_id'; // Primary key tabel

    protected $fillable = ['level_id', 'level_kode', 'level_nama'];

    public function user(): HasMany
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
    // use HasFactory;
    // protected $table = 'm_level';
    // protected  $primaryKey = 'level_id';

    // public function user(): HasMany
    // {
    //     return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    // }


