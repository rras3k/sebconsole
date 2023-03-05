<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Rras3k\Sebconsole\Lib\Mvc;
use Rras3k\Sebconsole\Lib\Models;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rras3k\Sebconsole\Http\Controllers\SbController;
use Rras3k\SebconsoleRoot\facades\Core;




class GenereMvcController extends Controller
{
    //
    public function getPara()
    {
    }
    public function show()
    {
        Core::init();

        $data = [];
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data['tables'] = Models::getTablesModelsGenerables();
        $data['table_select'] = "";

        if (isset($_GET['table']) && $_GET['table']) {
            $data['table_select'] = $_GET['table'];
            $genMvc = new Mvc();
            $data['infoChamps'] = $genMvc->analyseTable($_GET['table']);
            $data['infoEntite'] = $genMvc->getInfoEntiteDefault($_GET['table']);
        }
        //dd($data);
        return view('sebconsoleviews::genereSystem.mvc.saisi', compact('data'));
    }


    public function run(Request $request)
    {
        Core::init();

        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = [];
        $genMvc = new Mvc();
        $genMvc->initTable($request->props['table']);
        $genMvc->setProps($request->props);
        $genMvc->mergeChamps($request->champs);
        $data = $genMvc->genere($request->genereRoute, $request->genereOnlyModel );
        return view('sebconsoleviews::genereSystem.mvc.resultat', compact('data'));
    }

    public function check()
    {
        $genMvc = new Mvc();
        $genMvc->setProps([
            'model' => $_GET['model'],
            'table' => $_GET['table'],
            'label' => $_GET['label'],
            'themeCode' => $_GET['themeCode'],
            'themeUrl' => $_GET['themeUrl']
        ]);
        $genMvc->setFilesNames();
        $result = $genMvc->check();
        return response()->json($result, 200);
    }
}
