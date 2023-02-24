<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\Sb\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Rras3k\Sebconsole\Lib\GeneratorMenu;
use Rras3k\Sebconsole\Http\Controllers\SbController;




class genereSystemController extends SbController
{
    public function getPara()
    {
    }
    //
    public function show(){
        $data = array();
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        return view('sebconsoleviews::genereSystem.generation_show', compact('data'));
    }

    public function run(){
        $gen = new GeneratorMenu();
        $gen->genereAll();
        return $this->show();
    }

}
