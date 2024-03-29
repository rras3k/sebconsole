<?php

namespace Rras3k\Sebconsole\Models;

use  Rras3k\Sebconsole\Models\SbModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogType extends SbModel
{
    use HasFactory;

    //--- Mvc
    public static function getStrName()
    {
        return 'nom';
    }
    public static function getLabel()
    {
        return 'Type log';
    }
    public static function getList()
    {
        return LogType::select(['id', 'nom as label'])->where('is_enable', '=', 1)->orderBy('nom', 'asc')->get();
    }
}
