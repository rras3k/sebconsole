<?php



namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Rras3k\Sebconsole\Models\LogHead;
use Rras3k\Sebconsole\Models\LogDetail;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    static $logHeadId = null;

    public static function endHead(){
        self::$logHeadId = null;
    }

    public static function addDetail(string $texte, int $duree = null, int $num_error = null, int $log_head_id=null)
    {
        $LogDetail = new LogDetail();
        $LogDetail->texte = $texte;
        $LogDetail->user_id = Auth::user()->id;
        $LogDetail->log_head_id = $log_head_id ? $log_head_id : LogHead::TYPE_DEFAULT;
        $LogDetail->num_error = $num_error;
        $LogDetail->save();
    }

    public static function addHead(string $texte, int $duree = null, int $num_error = null){
        $logHead = new LogHead();
        $logHead->texte = $texte;
        $logHead->duree = $duree;
        $logHead->user_id = Auth::user()->id;
        $logHead->num_error = $num_error;
        $logHead->log_type_id = self::$logHeadId;
    }

}
