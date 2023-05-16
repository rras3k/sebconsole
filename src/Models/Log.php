<?php

namespace Rras3k\Sebconsole\Models;

use Illuminate\Support\Facades\Storage;
use Rras3k\Sebconsole\Models\LogDetail;
use Rras3k\Sebconsole\Models\LogHead;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




class Log
{
    private static $is_resistered = false;

    private static $log_id = null;


    public static function init($type = null)
    {
        // dd("oui");
        self::add('Demande de ressource');
    }

    public static function add($logMessage){
        if (!self::$is_resistered){
            self::$log_id = self::register();
            self::$is_resistered = true;
        }
        if(self::$is_resistered){
            $modLogDetail = new LogDetail();
            $modLogDetail->log_head_id = self::$log_id;
            $modLogDetail->texte = $logMessage;
            $modLogDetail->save();
        }
        else {
            return false;
        }
        return true;
    }

    private static function register(){
        // dd( Route::currentRouteAction(), Route::currentRouteName(), Route::getLastGroupPrefix(),Route::current(),Route::current()->uri);
        $modLogHead = new LogHead();
        $modLogHead->action = Route::currentRouteAction();
        $modLogHead->routeName = Route::currentRouteName();
        $modLogHead->uri = Route::current()->uri;
        $modLogHead->user_id = isset(Auth::user()->id) && Auth::user()->id ? Auth::user()->id : null;
        $modLogHead->save();
        return $modLogHead->id;

    }

    // public static function genereLogTypeConst(){
    //     $str = null;
    //     $logTypes = LogType::getList();
    //     $routes = Route::getRoutes();

    //     // dd($logTypes);
    //     $str = '<?php'."\n";
    //     foreach ($logTypes as $key => $value) {
    //         $str .= 'define("'.$value->label.'",'.$value->id.');'."\n";
    //     }
    //     Storage::disk('local')->put('private\\'.Log::NOM_FIC, $str);
    // }



}
