<?php

namespace Rras3k\Console\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Sb\ModuleService;
use Illuminate\Http\Request;

class GenerationController extends Controller
{
    //
    public function index(){
        $data = array();
        // $data['description'] = SbModule::doAwesomeThing();
        return view('console::generation-index', compact('data'));
    }
}
