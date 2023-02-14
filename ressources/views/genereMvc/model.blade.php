<?php
// dd($data);
?>
<{{$data['php']}}

namespace App\Models;

use  Rras3k\Sebconsole\Models\SbModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {{$data['this']->props['model']}} extends SbModel
{
    use HasFactory;

    //--- Mvc
    public static function getStrName()
    {
        return '{{$data['this']->props['champStr']}}';
    }
    public static function getLabel()
    {
        return '{{$data['this']->props['label']}}';
    }
    public static function getList()
    {
        return {{$data['this']->props['model']}}::select(['id', '{{$data['this']->props['champStr']}} as label'])->where('enable', '=', 1)->orderBy('{{$data['this']->props['champStr']}}', 'asc')->get();
    }
}
