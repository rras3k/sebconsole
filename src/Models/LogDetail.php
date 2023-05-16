<?php

namespace Rras3k\Sebconsole\Models;

use  Rras3k\Sebconsole\Models\SbModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDetail extends SbModel
{
    use HasFactory;

    public function add($message){
        $this->texte = $message;
        $this->user_id = Auth::user()->id;
    }


    //--- Mvc
    public static function getStrName()
    {
        return 'texte';
    }
    public static function getLabel()
    {
        return 'Détail des logs';
    }
    public static function getList()
    {
        return LogDetail::select(['id', 'texte as label'])->where('is_enable', '=', 1)->orderBy('texte', 'asc')->get();
    }
}
