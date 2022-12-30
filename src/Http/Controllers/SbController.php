<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*

// -- Paramètres
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

// -- rras3k
['rras3k']['menu_page'] // liste des mneus de la page
['rras3k']['form']['nom du formulaire']['nom du champ'] // Liste des champs avec leur valeur
['rras3k']['liste'] // Liste des listes (foreignId ...)

*/


abstract class SbController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    abstract public function getPara();

    private $menus;
    private $paras;
    // private $hiddens;
    // private $formPara;
    private $entree;
    private $entites = ['page' => []];


    /**
     *
     * @param
     * @return
     */
    public function __construct()
    {
        $this->menus = config('sebconsole.menu_page');
        $this->paras = $this->getPara();
        $this->setEntree('main');
    }


    public function setEntree($entree)
    {
        $this->entree = $entree;

        if (!isset($this->entites[$this->entree])) $this->entites[$this->entree] = [];

        // Form
        if (!isset($this->entites[$this->entree]['form'])) $this->entites[$this->entree]['form'] = [];
        $this->entites[$this->entree]['form']['isCreate'] = false;

        // Menu
        if (!isset($this->entites[$this->entree]['menu']))  $this->entites[$this->entree]['menu'] = [];
        $this->entites[$this->entree]['menu']['values'] = [];
        $this->entites[$this->entree]['menu']['liste'] = [];

        // lists
        if (!isset($this->entites[$this->entree]['lists']))  $this->entites[$this->entree]['lists'] = [];
    }

    private function loadPara()
    {
    }

    public function nav_setBreadCombre($breadcombreListe)
    {
        if (!isset($this->entites['page'])) $this->entites['page'] = ['nav' => ['breadcombre' => []]];
        $this->entites['page']['nav']['breadcombre'] = $breadcombreListe;
    }
    // -------------------------------------------------------- Page -------------------------------------------------------------

    /**
     *
     * @param
     * @return
     */
    public function page_setTitre($titre)
    {
        $this->entites[$this->entree]['titre'] = $titre;
    }

    // /**
    //  *
    //  * @param
    //  * @return
    //  */
    // private function page_getTitre($entite)
    // {
    //     return $this->entites[$this->entree]['titre'];
    // }

    // -------------------------------------------------------- Menu page --------------------------------------------------------

    /**
     *
     * @param
     * @return
     */
    private $values = []; // TODO

    /**
     *
     * @param
     * @return
     */
    public function menuPage_add($label, $url, $icon, $class = null)
    {
        $this->paras[$this->entree]['menu'][] = ["label" => $label, "url" => $url, "icon" => $icon, "class" => $class];
        // dd($this->paras);
        // $this->entites[$this->entree]['menu']['values'][$champId] = ['value_para' => $para_url, 'value_code' => $value];
        // $this->values[$champId] = ['value_para' => $para_url, 'value_code' => $value];
    }


    // /**
    //  *
    //  * @param
    //  * @return
    //  */
    // public function menuPage_setValues($nom, $values = null, $url_paras = null)
    // {
    //     $this->paras[$this->entree]['menu']['values'][$nom] = ['value_para' => $url_paras, 'values' => $values];
    //     // $this->entites[$this->entree]['menu']['values'][$champId] = ['value_para' => $para_url, 'value_code' => $value];
    //     // $this->values[$champId] = ['value_para' => $para_url, 'value_code' => $value];
    // }

    // /**
    //  *
    //  * @param
    //  * @return
    //  */
    // public function menuPage_addEntree($nom, $route, $titre, $icon)
    // {
    //     $this->menu[] = ['champ_id' => $champId, 'route' => $route, 'titre' => $titre, 'icon' => $icon];
    // }

    /**
     *
     * @param
     * @return
     */
    public function menuPage_get()
    {
        // dd($this->paras);
        foreach ($this->paras as $entree => $paraEntree) {
            $ret = [];
            if (isset($paraEntree['menu'])) {
                foreach ($paraEntree['menu'] as $ind => $menu) {
                    $this->entites[$entree]['menu_page'][] = ['titre' => $menu['label'], 'url' => $menu['url'],  'classIcon' =>  $menu['icon'], 'class' => $menu['class']];
                }
            }
        }
        return true;
    }
    /*
foreach ($this->paras as $entree => $paraEntree) {
            $ret = [];
            foreach ($this->menus as $ind => $menu) {
                if (Route::currentRouteName() != $menu['route'] && (isset($paraEntree['menu']['values'][$menu['champ_id']]['value_code']) || isset($paraEntree['menu']['values'][$menu['champ_id']]['value_para']))) {
                    $para = '';
                    // if ($paraEntree['menu']['values'][$menu['champ_id']]['value_para']) {
                    //     $para = '/' .  $paraEntree['values'][$menu['champ_id']]['value_para'];
                    // }
                    dd("-- menu --", $menu, '-- paraEntree --', $paraEntree, $menu['champ_id'], $paraEntree['menu']['values'][$menu['champ_id']]['value_para']);
                    if (isset($menu['condition']) && isset($paraEntree['menu']['values'][$menu['condition']['champ']]['value_code'])) {
                        switch ($menu['condition']['operateur']) {
                            case '==':
                                if ($paraEntree['menu']['values'][$menu['condition']['champ']]['value_code'] == $menu['condition']['value']) {
                                    $ret[] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $paraEntree['menu']['values'][$menu['champ_id']]['value_code']) . $para, 'classIcon' => 'fa-solid' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                                }
                                break;
                        }
                    } else {
                        if (!isset($ret[$entree])) $ret[$entree] = [];
                        $ret[$entree][] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $paraEntree['menu']['values'][$menu['champ_id']]['value_code']) . $para, 'classIcon' => 'fa-solid ' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                    }
                }
            }
            $this->entites[$entree]['menu_page'] = $ret;
*/
    /**
     *
     * @param
     * @return
     */
    public function aff($texte)
    {
        echo '<br/>' . $texte;
    }

    // -------------------------------------------------------- Formulaire --------------------------------------------------------

    /**
     *
     *
     * @param
     * @return
     */
    public function form_setIsCreate($isCreate)
    {
        $this->entites[$this->entree]['form']['isCreate'] = $isCreate;
    }

    // /**
    //  *
    //  *
    //  * @param
    //  * @return
    //  */
    // public function form_isCreate($entree){
    //     return $this->entites[$this->entree]['form']['isCreate'] ;
    // }

    /**
     *
     *
     * @param
     * @return
     */
    public function form_setHiddenValues($hiddens)
    {
        $this->entites[$this->entree]['form']['hiddens'] = $hiddens;
    }


    /**
     *
     *
     * @param
     * @return
     */
    public function form_buildData()
    {
        $ret = [];
        $table = $this->getTablePrincipale();
        $colomns = DB::select("SELECT COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
        foreach ($colomns as $ind => $column) {
            $ret[$column->COLUMN_NAME] = $column->COLUMN_DEFAULT;
        }
        $this->form_setData($ret);
    }



    /**
     *
     * @return
     */
    public function form_setData($list)
    {
        // dd($list);
        $ret = [];
        if ($list != null) {

            $list = is_array($list) ? $list : $list->toArray();
            if ($list) {
                foreach ($list as $key => $elt) {
                    $ret[$key] = old($key) ? old($key) : $elt;
                }
            }
        } else {
            dd("erreur");
        }
        // if (!isset($this->paras[$this->entree]['form'])) $this->paras[$this->entree]['form'] = [];
        $this->entites[$this->entree]['form']['datas'] = $ret;
    }

    // /**
    //  *
    //  * @return
    //  */
    // public function form_getData($entree)
    // {
    //     return $this->paras[$entree]['form']['datas'];
    // }

    // /**
    //  *
    //  * @param
    //  * @return
    //  */
    // public function getDataSet($list)
    // {
    //     $ret = [];
    //     $list = $list->toArray();
    //     if ($list) {
    //         foreach ($list as $key => $elt) {
    //             $ret[$key] = old($key) ? old($key) : $elt;
    //         }
    //     }
    //     return $ret;
    // }

    // public function getInfoTable($table)
    // {
    //     $ret = [];
    //     //        dd("SELECT COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
    //     $colomns = DB::select("SELECT COLUMN_NAME,COLUMN_DEFAULT,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '" . $table . "' ORDER BY ORDINAL_POSITION");
    //     // dd($colomns);
    //     foreach ($colomns as $ind => $column) {
    //         $ret[$column->COLUMN_NAME] = $colomns[$ind];
    //     }
    //     // dd($ret['id']);
    //     return $ret;
    // }

    // -------------------------------------------------------- Liste data --------------------------------------------------------

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

    /**
     *
     * @param
     * @return
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
     *
     * @param
     * @return
     */
    public function listeBootstrapTable($entree = 'main', $showRequete = false)
    {
        $requetePara = $this->getRequete($entree, false);
        if ($showRequete) dump($requetePara);
        $requeteNb = $this->getRequete($entree, true);
        $table = DB::select($requetePara['requete']);
        $nbRecords = DB::select($requeteNb['requete'])[0]->nb;
        return response()->json(array('total' => $nbRecords, 'totalNotFiltered' => $nbRecords, 'rows' => $this->getRealArray($table)));
    }



    /**
     *
     * @param
     * @return
     */
    public function getRequete($entree, $isForCount = false)
    {
        // dd($para);
        // dd($this->para);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : (isset($this->paras[$entree]['limit']) ? $_GET['limit'] : 25);

        // Récupération de la chaine pour la revherche
        $search = isset($_GET['search']) && $_GET['search'] ?  '%' . $_GET['search'] . '%' : '';

        // Création SELECT
        $select = '';
        foreach ($this->paras[$entree]['champs'] as $champ => $infoChamp) {
            $select .= $select ? ',' : '';
            $select .= isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] . ' as ' . $champ : $this->paras[$entree]['table_principale'] . '.' . $champ . ' as ' . $champ;
        }

        $offset = isset($_GET['offset']) ?  $_GET['offset'] : 0;
        // Création Sort
        if (isset($_GET['sort']) && $_GET['sort']) {
            $sort = isset($this->paras[$entree]['champs'][$_GET['sort']]['table']) ? $this->paras[$entree]['champs'][$_GET['sort']]['table'] . '.' . $this->paras[$entree]['champs'][$_GET['sort']]['champ_table'] : $this->paras[$entree]['table_principale'] . '.' . $_GET['sort'];
        } else {
            // echo $this->paras['champs'][$this->paras['sort_defaut']]['table'];
            $sort = isset($this->paras[$entree]['champs'][$this->paras[$entree]['sort_defaut']]['table']) ? $this->paras[$entree]['champs'][$this->paras[$entree]['sort_defaut']]['table'] . '.' . $this->paras[$entree]['champs'][$this->paras[$entree]['sort_defaut']]['champ_table'] : $this->paras[$entree]['table_principale'] . '.' . $this->paras[$entree]['sort_defaut'];
        }
        // Création Order
        $order = isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : $this->paras[$entree]['order_defaut'];


        // Création JOIN
        $join = '';
        foreach ($this->paras[$entree]['jointure'] as $jointure) {
            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
        }

        // Création orWhere  pour search
        $orWheres = '';
        if ($search) {
            foreach ($this->paras[$entree]['champs'] as $champ => $infoChamp) {
                $orWhereChamp = isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] : $this->paras[$entree]['table_principale'] . '.' . $champ;
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
                    if (isset($this->paras[$entree]['filtre'][$filtre]['jointure']) && $this->paras[$entree]['filtre'][$filtre]['jointure']) {
                        foreach ($this->paras[$entree]['filtre'][$filtre]['jointure'] as $jointure) {
                            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
                        }
                    }
                    $where = $where ? $where . ' && ' : $where;
                    $where .= $this->paras[$entree]['filtre'][$filtre]['champ'] . '=' . $value;
                }
            }
        }

        // Création Where FILTRE FIXE
        if (isset($_GET['filtre_fixe'])) {
            foreach ($_GET['filtre_fixe'] as $filtre => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $this->paras[$entree]['filtre_fixe'][$filtre] . '=' . $value;
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
            $requete = 'select count(*) as nb from ' . $this->paras[$entree]['table_principale'] . ' ' . $join . $where;
        } else {
            $requete = 'select ' . $select . ' from ' . $this->paras[$entree]['table_principale'] . ' ' . $join . $where . ' order by ' . $sort . ' ' . $order . ' limit ' . $limit . ' offset ' . $offset;
        }
        return  ['requete' => $requete, 'offset' => $offset, 'limit' => $limit];
    }

    /**
     *
     * @param
     * @return
     */
    public function filtreToString($para)
    {
        $ret = '';
        if (isset($_GET['filtre'])) {
            foreach ($_GET['filtre'] as $filtre => $value) {
                $requete = '';
                $join = '';
                if ($value) {
                    $res = DB::table($para['filtre'][$filtre]['table'])->where($para['filtre'][$filtre]['champ'], '=', $value)->pluck($para['filtre'][$filtre]['champToStr']);
                    $ret = $ret ? ', ' . $res[0] : $res[0];
                }
            }
        }
        return $ret;
    }

    /**
     *
     * @param
     * @return
     */
    public function data_setList($listNom, $listData)
    {
        $this->entites[$this->entree]['lists'][$listNom] = $listData;
    }


    // /**
    //  * Retourne les datas pour la view
    //  *
    //  * @param  none
    //  * @return tableau avec les datas
    //  */
    // public function listForFiltre($para)
    // {
    //     $ret = [];
    //     if (isset($para['filtre'])) {
    //         foreach ($para['filtre'] as  $filtre => $infos) {
    //             $ret[$filtre] = DB::table($para['filtre'][$filtre]['table'])->select($para['filtre'][$filtre]['champ'], $para['filtre'][$filtre]['champToStr'])->orderBy($para['filtre'][$filtre]['affichage_order'], $para['filtre'][$filtre]['affichage_by'])->get()->toArray();
    //         }
    //     }
    //     return $ret;
    // }

    /**
     * Retourne les datas pour la view
     *
     * @param  none
     * @return tableau avec les datas
     */

    public function dataToView()
    {
        $this->menuPage_get();
        return $this->entites;
    }


    // -----------------------
    private function getTablePrincipale()
    {
        return $this->paras[$this->entree]['table_principale'];
    }
}
