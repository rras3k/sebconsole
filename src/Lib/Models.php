<?php

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\DB;


class Models
{
    static $modelsNonModifiables = [
        'failed_jobs' => 'failed_jobs',
        'migrations' => 'migrations',
        'password_resets' => 'password_resets',
        'personal_access_tokens' => 'personal_access_tokens',
        'users' => 'users',
        'roles' => 'roles'
    ];

    public static function getTables()
    {
        $ret = [];

        $champName = 'Tables_in_' . env('DB_DATABASE');
        $tables = DB::select("show tables");
        foreach ($tables as $ind => $table) {
            if (!(isset(SELF::$modelsNonModifiables[$table->$champName]))) {
                $ret[$table->$champName] = $table->$champName;
            }
        }
        return $ret;
    }

    public static function getTablesModelsGenerables()
    {
        $ret = SELF::getTables();
        foreach ($ret as $key => $values) {
            // dd(app_path() . '/Models/' . SELF::getModelFromTableName($key));
            if (file_exists(app_path().'/Models/'.SELF::getModelFromTableName($key).'.php')) {
                $ret[$key] = 'X ' . $values;
            }
            else{
                $ret[$key] = '  ' . $values;

            }
        }

        return $ret;
    }

    private static function snakeToPascal($key)
    {
        return str_replace('_', '', ucwords($key, '_'));
    }

    public static function getModelFromTableName($tables)
    {
        $ret = SELF::snakeToPascal($tables);

        if (substr($ret, -1) == "s") return substr($ret, 0, strlen($ret) - 1);
        return $ret;
    }


    // public static function genereModel($tables)
    // {
    //     if (!file_exists($this->filePathModel)) {
    //         $data = ["this" => $this, 'php' => '?php'];
    //         View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
    //         $code = View('sebconsoleviews::genereSystem.mvc.model', compact('data'))->render();
    //         $this->writeFic($this->filePathModel, $code);
    //     }
    // }
}
