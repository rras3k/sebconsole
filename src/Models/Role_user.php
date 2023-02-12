<?php

namespace App\Models;

use  Rras3k\Sebconsole\Models\SbModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_user extends SbModel
{
    use HasFactory;

    //--- Mvc
    public static function getStrName()
    {
        return 'id';
    }
    public static function getLabel()
    {
        return 'Role par utilisateur';
    }
    public static function getList()
    {
        return LogHead::select(['id', 'id as label'])->where('enable', '=', 1)->orderBy('id', 'asc')->get();
    }
}
