<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class Authenticatable

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    // protected $table = 'm_user';
    // protected $primaryKey = 'user_id';

    // protected $fillable = ['level_id', 'username', 'nama', 'password', 'profile_photo', 'created_at', 'updated_at']; //kolom yang bisa diisi
    // protected $hidden = ['password']; //jangan ditampilkan pada saat select
    // protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

//     public function getJWTIdentifier()
//     {
//         return $this->getKey();
//     }

//     public function getJWTCustomClaims(array $payload)
//     {
//         return [];
//     }
// }
// {
    use HasFactory;
    protected $table ='m_user';
    protected $primaryKey='user_id';

    // protected $fillable = ['level_id', 'username', 'nama', 'password'];
    protected $fillable = ['level_id', 'username', 'nama', 'password', 'profile_photo','created_at', 'updated_at']; //kolom yang bisa diisi
     // protected $fillable = ['level_id', 'username', 'name'];
     protected $hidden = ['password']; //jangan ditampilkan pada saat select

     protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash


    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }
    
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
        }
    public function getRole()
    {
        return $this->level->level_kode;
    }

}
