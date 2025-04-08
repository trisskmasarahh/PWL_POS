<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class Authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;
    protected $table ='m_user';
    protected $primaryKey='user_id';

    // protected $fillable = ['level_id', 'username', 'nama', 'password'];
    protected $fillable = ['level_id', 'username', 'name', 'password', 'created_at', 'updated_at'];
     // protected $fillable = ['level_id', 'username', 'name'];
     protected $hidden = ['password']; //jangan ditampilkan pada saat select

     protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash


    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
