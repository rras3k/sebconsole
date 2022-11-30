<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Sb\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class GenerationController extends Controller
{
    //
    public function index(){
        $data = array();
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        // $data['description'] = SbModule::doAwesomeThing();
        return view('sebconsoleviews::generation-index', compact('data'));
    }
}
