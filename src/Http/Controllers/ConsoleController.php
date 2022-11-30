<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ConsoleController extends Controller
{
    //
    public function show(){
        $data=[];
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        return View::make('sebconsoleviews::console-show', compact('data'));
        // return view('console.console-show', compact('data'));
    }
}
