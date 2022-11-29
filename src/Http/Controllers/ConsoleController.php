<?php

namespace Rras3k\Console\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ConsoleController extends Controller
{
    //
    public function show(){
        $data=[];
        // View::addNamespace('console', 'Rras3k/console/views');

        return View::make('console::console-show', compact('data'));
        // return view('console.console-show', compact('data'));
    }
}
