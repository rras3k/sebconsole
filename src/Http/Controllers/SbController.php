<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*

[
            'table_principale' => 'users',
            'jointure' => [
            ],
            'champs' => [
                'id' => ['table' => 'users', 'champ_table' => 'id'],
                'name' => ['table' => 'users', 'champ_table' => 'name']
            ],
            'filtre' => [
                'role' => [
                    'table' => 'roles',
                    'champ' => 'roles.id',
                    'affichage_order' => 'roles.fonction',
                    'affichage_by' => 'asc',
                    'champToStr' => 'roles.fonction',
                    'jointure'=>[
                        ['type' => 'left join', 'table' => 'role_user', 'on' => 'role_user.user_id', 'cible' => 'users.id'],
                        ['type' => 'left join', 'table' => 'roles', 'on' => 'roles.id', 'cible' => 'role_user.role_id'],
                    ]
                ]
            ],
            'filtre_fixe' => [],
            'sort_defaut' => 'id',
            'order_defaut' => 'asc',
        ]



*/


abstract class SbController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    abstract public function getPara();

    private $menus;
    private $para;

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->menus = config('sebconsole.menu_page');
        $this->para = $this->getPara();
        // dd($this->para);
    }


    // -------------------------------------------------------- Menu page --------------------------------------------------------

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    private $values = []; // TODO

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function menuPage_add($champId, $value, $para_url = null)
    {
        $this->values[$champId] = ['value_para' => $para_url, 'value_code' => $value];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public static function menuPage_addEntree($champId, $route, $titre, $icon)
    {
        self::$menus[] = ['champ_id' => $champId, 'route' => $route, 'titre' => $titre, 'icon' => $icon];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function menuPage_get()
    {
        $ret = [];
        foreach ($this->menus as $menu) {
            if (Route::currentRouteName() != $menu['route'] && (isset($this->values[$menu['champ_id']]['value_code']) || isset($this->values[$menu['champ_id']]['value_para']))) {
                $para = '';
                if ($this->values[$menu['champ_id']]['value_para']) {
                    $para = '/' .  $this->values[$menu['champ_id']]['value_para'];
                }
                if (isset($menu['condition']) && isset($this->values[$menu['condition']['champ']]['value_code'])) {
                    switch ($menu['condition']['operateur']) {
                        case '==':
                            if ($this->values[$menu['condition']['champ']]['value_code'] == $menu['condition']['value']) {
                                $ret[] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $this->values[$menu['champ_id']]['value_code']) . $para, 'classIcon' => 'fa-solid' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                            }
                            break;
                    }
                } else {
                    $ret[] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $this->values[$menu['champ_id']]['value_code']) . $para, 'classIcon' => 'fa-solid ' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                }
            }
        }
        return $ret;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function aff($texte)
    {
        echo '<br/>' . $texte;
    }

    // -------------------------------------------------------- Formulaire --------------------------------------------------------

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function PrepareToEdit($list)
    {
        $ret = [];
        $list = $list->toArray();
        if ($list) {
            foreach ($list as $key => $elt) {
                $ret[$key] = old($key) ? old($key) : $elt;
            }
        }
        return $ret;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function getDataSet($list)
    {
        $ret = [];
        $list = $list->toArray();
        if ($list) {
            foreach ($list as $key => $elt) {
                $ret[$key] = old($key) ? old($key) : $elt;
            }
        }
        return $ret;
    }

    public function getInfoTable($table)
    {
        $ret = [];
//        dd("SELECT COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
        $colomns = DB::select("SELECT COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
        // dd($colomns);
        foreach ($colomns as $ind => $column) {
            $ret[$column->COLUMN_NAME] = $colomns[$ind];
        }
        // dd($ret['id']);
        return $ret;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function PrepareToCreate($table)
    {
        $ret = [];
        $colomns = DB::select("SELECT COLUMN_NAME,COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'coquinland-v2-dev' AND TABLE_NAME = 'urls' ORDER BY ORDINAL_POSITION");
        foreach ($colomns as $ind => $column) {
            $ret[$column->COLUMN_NAME] = $column->COLUMN_DEFAULT;
        }
        return $ret;
    }

    // -------------------------------------------------------- Liste data --------------------------------------------------------

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    private function getRealArray($tmp)
    {
        $a = array();
        foreach ($tmp as $ind => $row) {
            $a[] = $row;
        }
        return $a;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function filtreUrl()
    {
        $ret = '';
        if (isset($_GET['filtre'])) {
            foreach ($_GET['filtre'] as $filtre => $value) {
                if ($ret) $ret .= '&';
                $ret .= 'filtre[' . $filtre . ']=' . $value;
            }
        }
        return $ret ? '?' . $ret : '';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function listeBootstrapTable($showRequete = false)
    {
        $requetePara = $this->getRequete(false);
        if ($showRequete) dump($requetePara);
        $requeteNb = $this->getRequete(true);
        $table = DB::select($requetePara['requete']);
        $nbRecords = DB::select($requeteNb['requete'])[0]->nb;
        return response()->json(array('total' => $nbRecords, 'totalNotFiltered' => $nbRecords, 'rows' => $this->getRealArray($table)));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function getRequete($isForCount = false)
    {
            // dd($para);
        ;

        $limit = isset($_GET['limit']) ? $_GET['limit'] : (isset($this->para['limit']) ? $_GET['limit'] : 25);

        // Récupération de la chaine pour la revherche
        $search = isset($_GET['search']) && $_GET['search'] ?  '%' . $_GET['search'] . '%' : '';

        // Création SELECT
        $select = '';
        foreach ($this->para['champs'] as $champ => $infoChamp) {
            $select .= $select ? ',' : '';
            $select .= isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] . ' as ' . $champ : $this->para['table_principale'] . '.' . $champ . ' as ' . $champ;
        }

        $offset = isset($_GET['offset']) ?  $_GET['offset'] : 0;
        // Création Sort
        if (isset($_GET['sort']) && $_GET['sort']) {
            $sort = isset($this->para['champs'][$_GET['sort']]['table']) ? $this->para['champs'][$_GET['sort']]['table'] . '.' . $this->para['champs'][$_GET['sort']]['champ_table'] : $this->para['table_principale'] . '.' . $_GET['sort'];
        } else {
            // echo $this->para['champs'][$this->para['sort_defaut']]['table'];
            $sort = isset($this->para['champs'][$this->para['sort_defaut']]['table']) ? $this->para['champs'][$this->para['sort_defaut']]['table'] . '.' . $this->para['champs'][$this->para['sort_defaut']]['champ_table'] : $this->para['table_principale'] . '.' . $this->para['sort_defaut'];
        }
        // Création Order
        $order = isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : $this->para['order_defaut'];


        // Création JOIN
        $join = '';
        foreach ($this->para['jointure'] as $jointure) {
            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
        }

        // Création orWhere  pour search
        $orWheres = '';
        if ($search) {
            foreach ($this->para['champs'] as $champ => $infoChamp) {
                $orWhereChamp = isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] : $this->para['table_principale'] . '.' . $champ;
                $orWheres .= $orWheres ? ' || ' : $orWheres;
                $orWheres .= $orWhereChamp . ' like "' . $search . '"';
            }
            $orWheres = $orWheres ? ' ( ' . $orWheres . ' ) ' : $orWheres;
        }

        // Création Where FILTRE
        $where = '';
        // dd($_GET['filtre']);
        if (isset($_GET['filtre'])) {
            foreach ($_GET['filtre'] as $filtre => $value) {
                if ($value) {
                    if (isset($this->para['filtre'][$filtre]['jointure']) && $this->para['filtre'][$filtre]['jointure']) {
                        foreach ($this->para['filtre'][$filtre]['jointure'] as $jointure) {
                            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
                        }
                    }
                    $where = $where ? $where . ' && ' : $where;
                    $where .= $this->para['filtre'][$filtre]['champ'] . '=' . $value;
                }
            }
        }

        // Création Where FILTRE FIXE
        if (isset($_GET['filtre_fixe'])) {
            foreach ($_GET['filtre_fixe'] as $filtre => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $this->para['filtre_fixe'][$filtre] . '=' . $value;
            }
        }
        $where = $where ? ' ( ' . $where . ' ) ' : '';

        // Jonction where et orWhere
        if ($where && $orWheres) {
            $where .= ' && ' . $orWheres;
        } elseif ($orWheres) {
            $where .= $orWheres;
        }
        $where = $where ? ' where ' . $where : '';

        if ($isForCount) {
            $requete = 'select count(*) as nb from ' . $this->para['table_principale'] . ' ' . $join . $where;
        } else {
            $requete = 'select ' . $select . ' from ' . $this->para['table_principale'] . ' ' . $join . $where . ' order by ' . $sort . ' ' . $order . ' limit ' . $limit . ' offset ' . $offset;
        }
        return  ['requete' => $requete, 'offset' => $offset, 'limit' => $limit];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function filtreToString()
    {
        $ret = '';
        // if (isset($_GET['filtre_fixe'])) {
        //     foreach ($_GET['filtre_fixe'] as $filtre => $value) {
        //         $where = $where ? $where . ' && ' : $where;
        //         $where .= $this->para['filtre_fixe'][$filtre] . '=' . $value;
        //     }
        // }
        if (isset($_GET['filtre'])) {
            foreach ($_GET['filtre'] as $filtre => $value) {
                $requete = '';
                $join = '';
                if ($value) {
                    $res = DB::table($this->para['filtre'][$filtre]['table'])->where($this->para['filtre'][$filtre]['champ'], '=', $value)->pluck($this->para['filtre'][$filtre]['champToStr']);
                    // dd($res[0]);
                    $ret = $ret ? ', ' . $res[0] : $res[0];
                }
            }
        }
        return $ret;
    }

    /**
     * Retourne les datas pour la view
     *
     * @param  none
     * @return tableau avec les datas
     */
    public function listForFiltre()
    {
        $ret = [];
        if (isset($this->para['filtre'])) {
            foreach ($this->para['filtre'] as  $filtre => $infos) {
                // dump( $this->para['filtre']);
                // dd($filtre);
                // dd( $this->para['filtre'][$filtre]['table']);
                // dd( $this->para['filtre'][$filtre]['champ']);
                // dd($this->para['filtre'][$filtre]['champToStr']);
                $ret[$filtre] = DB::table($this->para['filtre'][$filtre]['table'])->select($this->para['filtre'][$filtre]['champ'], $this->para['filtre'][$filtre]['champToStr'])->orderBy($this->para['filtre'][$filtre]['affichage_order'], $this->para['filtre'][$filtre]['affichage_by'])->get()->toArray();
                // dump($ret[$filtre]);
            }
        }
        return $ret;
    }

    /**
     * Retourne les datas pour la view
     *
     * @param  none
     * @return tableau avec les datas
     */

    public function dataToView()
    {
        $ret = [];
        $ret['filtreToString'] = $this->filtreToString();
        $ret['listForFiltre'] = $this->listForFiltre();
        return $ret;
    }
}
