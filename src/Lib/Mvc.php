<?php
/*
Exemple:
Objectif: génération route, contrôler,View à partir d’un model

en entrée:
----------
- model : le nom du modèle => Formulaire
- themeCode : le nom du prefix pour le nom des fichiers
- themeUrl : le nom url du thème => mes-formulaires


Génération:
-----------

- Route:
Générer les routes pour index, create, store, edit et update
Route::get(‘console/affilies/mes-formulaires', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_index'])->name('affilies.mes_formulaires.index');
Route::get(‘console/affilies/mes-formulaires/listeBt', [App\Http\Controllers\FormulaireController::class, 'listeBt'])->name('affilies.mes_formulaires.listeBt');
Route::get(‘console/affilies/mes-formulaires/create', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_create'])->name('affilies.mes_formulaires.create');
Route::store(‘console/affilies/mes-formulaires/store', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_store'])->name('affilies.mes_formulaires.store');
Route::get(‘console/affilies/mes-formulaires/{formulaire}/edit', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_edit'])->name('affilies.mes_formulaires.edit');
Route::put(‘console/affilies/mes-formulaires/{formulaire}', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_update'])->name('affilies.mes_formulaires.update');
Route::get(‘console/affilies/mes-formulaires/{formulaire}', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_show'])->name('affilies.mes_formulaires.show');
Route::delete(‘console/affilies/mes-formulaires/{formulaire}', [App\Http\Controllers\FormulaireController::class, 'mes_formulaires_destroy'])->name('affilies.mes_formulaires.destroy');

- Controleur:
'new_'.modele.'Controller.php' => new_FormulaireController.php
Fonctions:
mes_formulaires_index :
mes_formulaires_create :
mes_formulaires_store :
mes_formulaires_edit :
mes_formulaires_update :
mes_formulaires_show :
mes_formulaires_destroy :


- Views:
mes_formulaires-index.blade.php
mes_formulaires-edit.blade.php
mes_formulaires-show.blade.php

*/

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\View;
use Rras3k\SebconsoleRoot\facades\RapportSimple;

// use Illuminate\View\View;



class Mvc
{
    const MODE_CREATION_FICHIER = 1;
    const MODE_CREATION_ = 1;
    public $champs = [];
    public $props = [];


    public $label; // str du model
    public $champStr; // champ du model donnant le str

    // routeName
    public $routeName_index;
    public $routeName_listeBt;
    public $routeName_edit;
    public $routeName_create;
    public $routeName_store;
    public $routeName_update;
    public $routeName_show;
    public $routeName_destroy;

    // functionNameController
    public $functionNameController_index;
    public $functionNameController_listeBt;
    public $functionNameController_edit;
    public $functionNameController_create;
    public $functionNameController_store;
    public $functionNameController_update;
    public $functionNameController_show;
    public $functionNameController_destroy;

    // ControllerName
    public $fileNameController;

    // fileName
    public $fileNameRoute;
    public $filePathController;
    public $filePathModel;
    public $fileNameView_index;
    public $fileNameView_edit;
    public $fileNameView_create;
    public $fileNameView_show;

    // call view
    public $callView_index;
    public $callView_edit;
    public $callView_create;
    public $callView_show;


    public function genere($genereRoute = false, $genereOnlyModel = false)
    {
        // dd($genereRoute, $genereOnlyModel);
        $ret = ["toConfig" => "", 'texte' => []];
        $this->setRouteName();
        $this->setFilesNames();
        $this->setCallViews();
        $this->setFunctionNameController();
        if (!$genereOnlyModel) {
            if ($genereRoute) $this->genereRoute();
        }
        $this->genereModel();

        if (!$genereOnlyModel) {
            $this->genereController();
            $this->genereView();
            $ret["toConfig"] = "[  'label' => '" . $this->props['label'] . "', 'route' => '" . $this->routeName_index . "', 'icon' => 'fa-solid fa-city', 'droits'=> [Role::ADMIN], 'items'=>[] ],";
        }
        return $ret;
    }
    public function setProps($props)
    {
        $this->props = $props;
    }

    public function mergeChamps($champs)
    {
        // dump($this->champs);
        // dump($champs);
        $this->champs = array_replace_recursive($this->champs, $champs);
        // dd($this->champs);
    }

    public function initTable($table)
    {
        $this->champs = $this->analyseTable($table);
    }

    public function analyseTable($table)
    {
        $ret = [];
        // $colomns = DB::select("SELECT data_type, COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "'  AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
        $colomns = DB::select("SHOW COLUMNS FROM " . $table);
        foreach ($colomns as $ind => $column) {

            $colonneNom = $column->Field;
            $colonneTypeMysql = $column->Type;

            // $colonneNom = $column->COLUMN_NAME;
            // $colonneTypeMysql = $column->DATA_TYPE;

            $ret[$colonneNom] = [];
            $ret[$colonneNom]['name'] = $colonneNom;
            $ret[$colonneNom]['type_mysql'] = $colonneTypeMysql;
            $ret[$colonneNom]['type'] = $this->getType($colonneTypeMysql);

            $ret[$colonneNom]['form'] = [];
            $ret[$colonneNom]['form']['label'] = $colonneNom;
            $ret[$colonneNom]['form']['visible'] = $this->isSavable($colonneNom);

            $ret[$colonneNom]['grille'] = [];
            $ret[$colonneNom]['grille']['label'] = $colonneNom;
            $ret[$colonneNom]['grille']['visible'] = $this->isSavable($colonneNom);

            $ret[$colonneNom]['link'] = ['enable' => false];
            if (substr($colonneNom, -3) == "_id") {
                $ret[$colonneNom]['link']['enable'] = true;
                $aroundLinkTable = substr($colonneNom, 0, strlen($colonneNom) - 3);
                $ret[$colonneNom]['link']['model'] = $this->getLinkModel($aroundLinkTable);
                $ret[$colonneNom]['link']['table'] = $this->getLinkTable($aroundLinkTable);
                $ret[$colonneNom]['link']['str'] = $this->getModelStr($ret[$colonneNom]['link']['model']);
                $ret[$colonneNom]['link']['label'] = $this->getLinkLabel($ret[$colonneNom]['link']['model']);
                // $ret[$colonneNom]['label'] = $ret[$colonneNom]['link']['label'];
            }
        }
        return $ret;
    }

    private function getType($typeMysql)
    {
        if ($typeMysql == 'tinyint(1)') return 'boolean';
        if (substr($typeMysql, 0, 7) == 'varchar') return 'varchar';
        if (substr($typeMysql, 0, 4) == 'text') return 'text';
        if (substr($typeMysql, 0, 6) == 'bigint') return 'numeric';
        if (substr($typeMysql, 0, 7) == 'integer') return 'numeric';
        if (substr($typeMysql, 0, 7) == 'tinyint') return 'numeric';
        if (substr($typeMysql, 0, 3) == 'int') return 'numeric';

        // switch($typeMysql){
        // 	case
        // }
        return 'varchar';
    }


    private  function snakeToCamel($input)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }

    private function snakeToPascal($key)
    {
        return str_replace('_', '', ucwords($key, '_'));
    }

    private function getLinkLabel($model)
    {
        $myClass = $this->getClassName($model);
        return $myClass::getLabel();
    }
    private function getLinkModel($aroundLinkTable)
    {
        $ret = $this->snakeToPascal($aroundLinkTable);
        // dump($ret);
        if (substr($ret, -1) == "s") $ret = substr($ret, 0, strlen($ret) - 1);
        return $ret;
    }

    private function getLinkTable($aroundLinkTable)
    {
        $ret = nl2br($aroundLinkTable);
        if (substr($ret, -1) != "s") $ret .= 's';
        return $ret;
    }

    private function isSavable($champNom)
    {
        if (
            $champNom == 'is_enable'  ||
            $champNom == 'id' ||
            $champNom == 'created_at' ||
            $champNom == 'updated_at'
        ) {
            return 0;
        }
        return 1;
    }


    public function getInfoEntiteDefault($table)
    {
        return [
            'table' => $table,
            'model' => $this->getLinkModel($table),
            'themeCode' => $this->getLinkModel($table) . '_console',
            'label' => $table,
            // 'label' => $this->getClassName($this->getLinkModel($table))::getLabel(),
            'themeUrl' => 'console/' . $table,
        ];
    }

    public function setFilesNames()
    {
        // $this->fileNameRoute = base_path() . '/routes/' . $this->props['themeUrl'] . '_web.php.gMVC';
        $this->fileNameRoute = base_path() . '/routes/web.php';
        $this->fileNameController =  $this->props['themeCode'] . '_Controller';
        $this->filePathController = base_path() . '/app/Http/Controllers/' . $this->fileNameController . '.php';
        $this->filePathModel = base_path() . '/app/Models/' . $this->props['model'] . '.php';

        $pathView = $this->getPathView();

        $this->fileNameView_index = $pathView .  '_index.blade.php';
        $this->fileNameView_edit = $pathView .  '_edit.blade.php';
        $this->fileNameView_create = $pathView .  '_create.blade.php';
        $this->fileNameView_show = $pathView .  '_show.blade.php';
        return true;
    }

    private function getPathView()
    {
        return base_path() . '/resources/views/' . $this->props['themeCode'];
    }

    public function check()
    {
        $ok = true;
        $ok = $this->checkExistFiles() ? true : false;
        return ['titre' => RapportSimple::getTitre(), 'messages' => RapportSimple::getHtml()];
    }

    public function checkExistFiles()
    {
        // return RapportSimple::test();
        $processOk = true;
        RapportSimple::addTitle("Vérification avant génération VMC");
        RapportSimple::setMessageForBool("N'existe pas", "Existe");

        // RouteName
        // RapportSimple::add("Route", 3);
        // $isFileExists = file_exists($this->fileNameRoute);
        // $processOk = $processOk && !$isFileExists;
        // RapportSimple::add($this->fileNameRoute, 1, !$isFileExists);

        // Model
        RapportSimple::add("Modèles", 3);
        $isFileExists = file_exists($this->filePathModel);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->filePathModel, 1, !$isFileExists);


        // Controller
        RapportSimple::add("Controller", 3);
        $isFileExists = file_exists($this->filePathController);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->filePathController, 1, !$isFileExists);

        // View
        RapportSimple::add("View",  3);

        $isFileExists = file_exists($this->fileNameView_index);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->fileNameView_index, 1, !$isFileExists);

        $isFileExists = file_exists($this->fileNameView_edit);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->fileNameView_edit, 1, !$isFileExists);

        $isFileExists = file_exists($this->fileNameView_create);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->fileNameView_create, 1, !$isFileExists);

        $isFileExists = file_exists($this->fileNameView_show);
        $processOk = $processOk && !$isFileExists;
        RapportSimple::add($this->fileNameView_show, 1, !$isFileExists);

        if ($processOk) {
            RapportSimple::add("Vérification Ok",  1, 1);
        }
        return $processOk;
    }

    private function setCallViews()
    {


        $this->callView_index = $this->props['themeCode'] . '_index';
        $this->callView_edit = $this->props['themeCode'] . '_edit';
        $this->callView_create = $this->props['themeCode'] . '_create';
        $this->callView_show = $this->props['themeCode'] . '_show';
    }

    private function setRouteName()
    {
        $this->routeName_index = $this->props['themeCode'] . '.index';
        $this->routeName_listeBt = $this->props['themeCode'] . '.listeBt';
        $this->routeName_edit = $this->props['themeCode'] . '.edit';
        $this->routeName_create = $this->props['themeCode'] . '.create';
        $this->routeName_store = $this->props['themeCode'] . '.store';
        $this->routeName_update = $this->props['themeCode'] . '.update';
        $this->routeName_show = $this->props['themeCode'] . '.show';
        $this->routeName_destroy = $this->props['themeCode'] . '.destroy';
    }

    private function setFunctionNameController()
    {
        $this->functionNameController_index =  'index';
        $this->functionNameController_listeBt = 'listeBt';
        $this->functionNameController_edit = 'edit';
        $this->functionNameController_create = 'create';
        $this->functionNameController_store = 'store';
        $this->functionNameController_update = 'update';
        $this->functionNameController_show = 'show';
        $this->functionNameController_destroy = 'destroy';
    }

    private function genereRoute()
    {
        $content = "";
        $patController = 'App\\Http\\Controllers\\';
        $prefix =  $this->props['themeUrl'];

        $controllerName =  $this->props['themeCode'];

        // $file = 'routes/' . $this->props['themeUrl'] . '_web.php.gMVC';
        $content .= "\r\n";
        $content .= "\r\n";
        $content .= "// " . $this->props['model'];
        $content .= "\r\n";
        $content .= 'Route::get(\'' . $prefix .  '\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_index . '\'])->name(\'' . $this->routeName_index . '\');';
        $content .= "\r\n";
        $content .= 'Route::get(\'' . $prefix .  '/listeBt\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_listeBt . '\'])->name(\'' . $this->routeName_listeBt . '\');';
        $content .= "\r\n";
        $content .= 'Route::get(\'' . $prefix .  '/create\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_create . '\'])->name(\'' . $this->routeName_create . '\');';
        $content .= "\r\n";
        $content .= 'Route::post(\'' . $prefix .  '/store\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_store . '\'])->name(\'' . $this->routeName_store . '\');';
        $content .= "\r\n";
        $content .= 'Route::get(\'' . $prefix .  '/{id}/edit\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_edit . '\'])->name(\'' . $this->routeName_edit . '\');';
        $content .= "\r\n";
        $content .= 'Route::put(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_update . '\'])->name(\'' . $this->routeName_update . '\');';
        $content .= "\r\n";
        $content .= 'Route::get(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_show . '\'])->name(\'' . $this->routeName_show . '\');';
        $content .= "\r\n";
        $content .= 'Route::delete(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . '_Controller::class,\'' . $this->functionNameController_destroy . '\'])->name(\'' . $this->routeName_destroy . '\');';

        $this->writeFic($this->fileNameRoute, $content, "a");
        return $content;
    }


    private function writeFic($pathFic, $content, $modeOuverture = "w")
    {
        // dd(getcwd(), base_path());
        $handle = fopen($pathFic, $modeOuverture);
        fwrite($handle, $content);
        fclose($handle);
    }

    /**
     *
     * @param
     * @return
     */
    private function getRealArray($tmp)
    {
        $a = array();
        foreach ($tmp as $ind => $row) {
            $a[] = $row;
        }
        return $a;
    }

    private function getClassName($model)
    {
        return '\App\Models\\' . $model;
    }

    private function getModelStr($model)
    {
        $myClass = $this->getClassName($model);
        return $myClass::getStrName();
    }

    private function genereModel()
    {
        if (!file_exists($this->filePathModel)) {
            $data = ["this" => $this, 'php' => '?php'];
            View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
            $code = View('sebconsoleviews::genereSystem.mvc.model', compact('data'))->render();
            $this->writeFic($this->filePathModel, $code);
        }
    }

    private function genereController()
    {
        // $strName = $this->getModelStr($this->props['model']);

        $data = ["this" => $this, 'php' => '?php'];
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $codeController = View('sebconsoleviews::genereSystem.mvc.controller', compact('data'))->render();
        $this->writeFic($this->filePathController, $codeController);
    }

    private function genereView()
    {
        $data = ["this" => $this, 'php' => '?php', 'aco' => '{'];
        // $pathView = $this->getPathView();
        // if (!file_exists($pathView)) {
        // 	mkdir($pathView);
        // }

        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        // index
        $codeView = View('sebconsoleviews::genereSystem.mvc.view-index', compact('data'))->render();
        $this->writeFic($this->fileNameView_index, $codeView);

        // edit
        $codeView = View('sebconsoleviews::genereSystem.mvc.view-edit', compact('data'))->render();
        $this->writeFic($this->fileNameView_edit, $codeView);
    }
}
/*
        SELECT data_type, COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'app.monaform' AND TABLE_NAME = 'formulaires' ORDER BY ORDINAL_POSITION

*/
