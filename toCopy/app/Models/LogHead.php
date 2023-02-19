<?php

namespace App\Models;

use  Rras3k\Sebconsole\Models\SbModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHead extends SbModel
{
    use HasFactory;
    const TYPE_DEFAULT = 1;

    //--CONSTANTE Constantes générées
    //--CONSTANTE-END

    //--- Mvc
    public static function getStrName()
    {
        return 'texte';
    }
    public static function getLabel()
    {
        return 'Entête log';
    }
    public static function getList()
    {
        return LogHead::select(['id', 'texte as label'])->where('is_enable', '=', 1)->orderBy('texte', 'asc')->get();
    }
}
