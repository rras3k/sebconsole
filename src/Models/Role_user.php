<?php

namespace Rras3k\Sebconsole\Models;

use  Rras3k\Sebconsole\Models\SbModel;
use Rras3k\Sebconsole\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Role_user extends SbModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    //--- Mvc
    public static function getStrName()
    {
        return 'id';
    }
    public static function getLabel()
    {
        return 'Rôle par utilisateur';
    }
    public static function getList()
    {
        return Role_user::select(['id', 'id as label'])->where('is_enable', '=', 1)->orderBy('id', 'asc')->get();
    }
    public static function getMyList($user_id)
    {
        $datas = DB::select("select * from role_user where enable = 1 and user_id=".$user_id);
        return $datas;
    }
}
