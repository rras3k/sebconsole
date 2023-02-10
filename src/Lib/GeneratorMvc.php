<?php
/*
Exemple:
php artisan sebconsole:mvc LogType log_types logType logType  --prefix1=console --prefix2=admin 
php artisan sebconsole:mvc LogHead log_heads logHead logHead  --prefix1=console --prefix2=admin 
Objectif: génération route, contrôler,View à partir d’un model

en entrée:
----------
- model : le nom du modèle => Formulaire
- themeCode : le nom du prefix dans le code, nom des fichiers => mes_formulaires
- themeUrl : le nom url du thème => mes-formulaires
- préfix1 route => console
- préfix2 route => affilies

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
'/ressources/views/'.prefix2.'/' => /ressources/views/affilies/...
mes_formulaires-index.blade.php
mes_formulaires-edit.blade.php
mes_formulaires-show.blade.php

*/

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\View;
use Rras3k\SebconsoleRoot\facades\RapportSimple;

// use Illuminate\View\View;



class GeneratorMvc
{
	const MODE_CREATION_FICHIER = 1;
	const MODE_CREATION_ = 1;
	public $champs = [];
	public $props = [];
	// public $mvc = [
	// 	'route'=>[
	// 		'mode-creation' => 'fichier', // ou 'insertion'
	// 	],
	// 	'controller'=>[
	// 		'mode-creation' => 'fichier', // ou 'insertion'
	// 	],
	// 	'route'=>[
	// 		'mode-creation' => 'fichier', // ou 'insertion'
	// 	],
	// ];

	// Arguments & options
	// public $model;
	// public $table;
	// public $themeCode;
	// public $themeUrl;
	// public $prefix1;
	// public  $prefix2;

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
	public $fileNameView_index;
	public $fileNameView_edit;
	public $fileNameView_create;
	public $fileNameView_show;

	// call view
	public $callView_index;
	public $callView_edit;
	public $callView_create;
	public $callView_show;


	public function genere()
	{
		$ret = ["toConfig"=>"", 'texte'=>[]];
		$this->setRouteName();
		$this->setFilesNames();
		$this->setCallViews();
		$this->setFunctionNameController();
		//a remettre pour ecrire dans web.php  $this->genereRoute();
		// $this->genereRoute();
		$this->genereController();
		$this->genereView();
		$ret["toConfig"] = "[ 'rubrique' => 'Nouvel ajout', 'nom' => '". $this->props['label']."', 'route' => '".$this->routeName_index."', 'icon' => 'fa-solid fa-city', 'droits'=> [Role::ADMIN]],";

		return $ret;
	}
	public function setProps($props)
	{
		$this->props = $props;
	}

	public function mergeChamps($champs)
	{
		$this->champs = array_replace_recursive($this->champs, $champs);
	}

	public function initTable($table)
	{
		$this->champs = $this->analyseTable($table);
	}

	public function analyseTable($table)
	{
		$ret = [];
		$colomns = DB::select("SELECT data_type, COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "'  AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
		foreach ($colomns as $ind => $column) {
			$ret[$column->COLUMN_NAME] = [];
			$ret[$column->COLUMN_NAME]['name'] = $column->COLUMN_NAME;
			$ret[$column->COLUMN_NAME]['type'] = $column->DATA_TYPE;

			$ret[$column->COLUMN_NAME]['form'] = [];
			$ret[$column->COLUMN_NAME]['form']['label'] = $column->COLUMN_NAME;
			$ret[$column->COLUMN_NAME]['form']['visible'] = $this->isSavable($column->COLUMN_NAME);

			$ret[$column->COLUMN_NAME]['grille'] = [];
			$ret[$column->COLUMN_NAME]['grille']['label'] = $column->COLUMN_NAME;
			$ret[$column->COLUMN_NAME]['grille']['visible'] = $this->isSavable($column->COLUMN_NAME);

			$ret[$column->COLUMN_NAME]['link'] = ['enable' => false];
			if (substr($column->COLUMN_NAME, -3) == "_id") {
				$ret[$column->COLUMN_NAME]['link']['enable'] = true;
				$aroundLinkTable = substr($column->COLUMN_NAME, 0, strlen($column->COLUMN_NAME) - 3);
				$ret[$column->COLUMN_NAME]['link']['model'] = $this->getLinkModel($aroundLinkTable);
				$ret[$column->COLUMN_NAME]['link']['table'] = $this->getLinkTable($aroundLinkTable);
				$ret[$column->COLUMN_NAME]['link']['str'] = $this->getModelStr($ret[$column->COLUMN_NAME]['link']['model']);
				$ret[$column->COLUMN_NAME]['link']['label'] = $this->getLinkLabel($ret[$column->COLUMN_NAME]['link']['model']);
				// $ret[$column->COLUMN_NAME]['label'] = $ret[$column->COLUMN_NAME]['link']['label'];
			}
		}
		return $ret;
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
		if ($champNom == 'enable' || $champNom == 'id' || $champNom == 'created_at' || $champNom == 'updated_at') {
			return 0;
		}
		return 1;
	}

	// private function setArgument($model, $table, $themeCode, $themeUrl, $prefix1, $prefix2)
	// {
	// 	$this->props['model'] = $model;
	// 	$this->table = $table;
	// 	$this->themeCode = $themeCode;
	// 	$this->props['themeUrl'] = $themeUrl;
	// 	$this->props['prefix1'] = $prefix1;
	// 	$this->props['prefix2'] = $prefix2;
	// }

	public function getInfoEntite($table)
	{
		return [
			'table' => $table,
			'model' => $this->getLinkModel($table),
			'themeCode' => $this->getLinkModel($table).'_console_admin',
			'label' => $this->getClassName($this->getLinkModel($table))::getLabel(),
			'themeUrl' => $table,
			'prefix1' => 'console',
			'prefix2' => 'admin',
		];
	}

	public function setFilesNames()
	{
		// $this->fileNameRoute = base_path() . '/routes/' . $this->props['themeUrl'] . '_web.php.gMVC';
		$this->fileNameRoute = base_path() . '/routes/web.php';
		$this->fileNameController = $this->props['model'] . '__' . $this->props['themeCode'] . 'Controller';
		$this->filePathController = base_path() . '/app/Http/Controllers/' . $this->fileNameController.'.php';

		$pathView = $this->getPathView();

		$this->fileNameView_index = $pathView .  '-index.blade.php';
		$this->fileNameView_edit = $pathView .  '-edit.blade.php';
		$this->fileNameView_create = $pathView .  '-create.blade.php';
		$this->fileNameView_show = $pathView .  '-show.blade.php';
		return true;
	}

	private function getPathView()
	{
		$prefix = '';
		if ($this->props['prefix2']) $prefix = $this->props['prefix2'] . '/';
		return base_path() . '/resources/views/' . $this->props['model'] . '__' . $this->props['themeCode'];
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

		// RouteName
		// RapportSimple::add("Route", 3);
		// $isFileExists = file_exists($this->fileNameRoute);
		// $processOk = $processOk && !$isFileExists;
		// RapportSimple::add($this->fileNameRoute, 1, !$isFileExists);

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
		$prefix = '';
		if ($this->props['prefix2']) $prefix = $this->props['prefix2'] . '.';

		$this->callView_index = $prefix . $this->props['themeCode'] . '-index';
		$this->callView_edit = $prefix . $this->props['themeCode'] . '-edit';
		$this->callView_create = $prefix . $this->props['themeCode'] . '-create';
		$this->callView_show = $prefix . $this->props['themeCode'] . '-show';
	}

	private function setRouteName()
	{
		$prefixRouteName = "";
		if ($this->props['prefix2']) $prefixRouteName = $this->props['prefix2'] . '.';
		$this->routeName_index = $prefixRouteName . $this->props['themeCode'] . '.index';
		$this->routeName_listeBt = $prefixRouteName . $this->props['themeCode'] . '.listeBt';
		$this->routeName_edit = $prefixRouteName . $this->props['themeCode'] . '.edit';
		$this->routeName_create = $prefixRouteName . $this->props['themeCode'] . '.create';
		$this->routeName_store = $prefixRouteName . $this->props['themeCode'] . '.store';
		$this->routeName_update = $prefixRouteName . $this->props['themeCode'] . '.update';
		$this->routeName_show = $prefixRouteName . $this->props['themeCode'] . '.show';
		$this->routeName_destroy = $prefixRouteName . $this->props['themeCode'] . '.destroy';
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
		// $this->functionNameController_index = $this->props['themeCode'] . '_index';
		// $this->functionNameController_listeBt = $this->props['themeCode'] . '_listeBt';
		// $this->functionNameController_edit = $this->props['themeCode'] . '_edit';
		// $this->functionNameController_create = $this->props['themeCode'] . '_create';
		// $this->functionNameController_store = $this->props['themeCode'] . '_store';
		// $this->functionNameController_update = $this->props['themeCode'] . '_update';
		// $this->functionNameController_show = $this->props['themeCode'] . '_show';
		// $this->functionNameController_destroy = $this->props['themeCode'] . '_destroy';
	}

	private function genereRoute()
	{
		$content = "";
		$prefix = "";
		$prefixRouteName = "";
		$patController = 'App\\Http\\Controllers\\';
		if ($this->props['prefix1'] && $this->props['prefix2'])
			$prefix = $this->props['prefix1'] . '/' . $this->props['prefix2'] . '/';
		elseif ($this->props['prefix1'] && !$this->props['prefix2'])
			$prefix = $this->props['prefix1'] . '/';
		elseif (!$this->props['prefix1'] && $this->props['prefix2'])
			$prefix = $this->props['prefix2'] . '/';
		$prefix .=  $this->props['themeUrl'];
		$controllerName = $this->props['model'].'__'. $this->props['themeCode'];

		// $file = 'routes/' . $this->props['themeUrl'] . '_web.php.gMVC';
		$content .= "\r\n";
		$content .= "\r\n";
		$content .= "// ". $this->props['model'];
		$content .= "\r\n";
		$content .= 'Route::get(\'' . $prefix .  '\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_index . '\'])->name(\'' . $this->routeName_index . '\');';
		$content .= "\r\n";
		$content .= 'Route::get(\'' . $prefix .  '/listeBt\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_listeBt . '\'])->name(\'' . $this->routeName_listeBt . '\');';
		$content .= "\r\n";
		$content .= 'Route::get(\'' . $prefix .  '/create\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_create . '\'])->name(\'' . $this->routeName_create . '\');';
		$content .= "\r\n";
		$content .= 'Route::post(\'' . $prefix .  '/store\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_store . '\'])->name(\'' . $this->routeName_store . '\');';
		$content .= "\r\n";
		$content .= 'Route::get(\'' . $prefix .  '/{id}/edit\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_edit . '\'])->name(\'' . $this->routeName_edit . '\');';
		$content .= "\r\n";
		$content .= 'Route::put(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_update . '\'])->name(\'' . $this->routeName_update . '\');';
		$content .= "\r\n";
		$content .= 'Route::get(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_show . '\'])->name(\'' . $this->routeName_show . '\');';
		$content .= "\r\n";
		$content .= 'Route::delete(\'' . $prefix .  '/{id}\', [' . $patController . $controllerName . 'Controller::class,\'' . $this->functionNameController_destroy . '\'])->name(\'' . $this->routeName_destroy . '\');';

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

	private function genereController()
	{
		$strName = $this->getModelStr($this->props['model']);

		$data = ["this" => $this, 'php' => '?php', 'strName' => $strName];
		View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
		// $codeController = View('sebconsoleviews::genereMvc.controller', compact(['data']))->render();
		$codeController = View('sebconsoleviews::genereMvc.controller', compact('data'))->render();



		$this->writeFic($this->filePathController, $codeController);
	}

	private function genereView()
	{
		$data = ["this" => $this, 'php' => '?php', 'aco' => '{'];
		$pathView = $this->getPathView();
		if (!file_exists($pathView)) {
			mkdir($pathView);
		}

		View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

		// index
		$codeView = View('sebconsoleviews::genereMvc.view-index', compact('data'))->render();
		$this->writeFic($this->fileNameView_index, $codeView);

		// edit
		$codeView = View('sebconsoleviews::genereMvc.view-edit', compact('data'))->render();
		$this->writeFic($this->fileNameView_edit, $codeView);
	}
}
/*
        SELECT data_type, COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'app.monaform' AND TABLE_NAME = 'formulaires' ORDER BY ORDINAL_POSITION

*/