<?php
namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Rras3k\Sebconsole\Lib\GeneratorMvc;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class GenereMvcController extends Controller
{
    //

    public function show(){
        $data = [];
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data['tables'] = $this->getTables();
        $data['table_select'] = "";
        
        if (isset($_GET['table'])){
            $data['table_select'] = $_GET['table'];
            $genMvc = new GeneratorMvc();
            $data['infoChamps'] = $genMvc->analyseTable($_GET['table']);
            $data['infoEntite'] = $genMvc->getInfoEntite($_GET['table']);
        }
        //dd($data);
        return view('sebconsoleviews::genereMvc.saisi', compact('data'));
    }

    public function getTables(){
        $ret=[];
        $tables = DB::select("show tables");
        foreach ($tables as $ind => $table) {
            if($table->Tables_in_package != 'failed_jobs' 
            && $table->Tables_in_package != 'migrations'
            && $table->Tables_in_package != 'password_resets'
            && $table->Tables_in_package != 'personal_access_tokens'
            ){
                $ret[$table->Tables_in_package] = $table->Tables_in_package;
            }
        }
        return $ret;
		
    }
    public function run(Request $request)
    {
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = [];

        $genMvc = new GeneratorMvc();
        $genMvc->initTable($request->props['table']);
        $genMvc->setProps($request->props);
        $genMvc->mergeChamps($request->champs);
        $genMvc->genere();
        return view('sebconsoleviews::genereMvc.resultat', compact('data'));

    }

    public function check()
    {
        $genMvc = new GeneratorMvc();
        $genMvc->setProps(['model'=>$_GET['model'], 'table' => $_GET['table'], 'themeCode' => $_GET['themeCode'], 'themeUrl' => $_GET['themeUrl'], 'prefix1' => $_GET['prefix1'], 'prefix2' => $_GET['prefix2']]);
        $genMvc->setFilesNames();
        $result = $genMvc->check();
        return response()->json($result, 200); 

    }

}
