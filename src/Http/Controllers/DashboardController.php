<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
// use Illuminate\Support\Facades\DB;
// use Rras3k\Sebconsole\Lib\Mvc;
// use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Rras3k\SebconsoleRoot\facades\Core;
use Rras3k\SebconsoleRoot\facades\Menu;





class DashBoardController extends Controller
{
    //
    public function show()
    {
        $data=[];
        Core::init();
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        return view('sebconsoleviews::dashboard', compact('data'));

    }

    public function delMenus(){
        $data = [];
        Menu::delMenus();
        Core::init();
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        return view('sebconsoleviews::dashboard', compact('data'));
    }
}
