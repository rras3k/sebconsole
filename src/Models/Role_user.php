<?php

namespace Rras3k\Console\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    use HasFactory;
    public static function liste($userId){
        return SELF::leftjoin('roles','role.id','=','role_user.role.id')->where('user_id', $userId)->get()->keyBy('role.nom');
    }
}
