<?php

namespace Rras3k\Sebconsole\Lib;

use Rras3k\SebconsoleRoot\facades\RoleUser;
use Rras3k\SebconsoleRoot\facades\Menu;
use Illuminate\Support\Facades\DB;


class Core
{
    private $BUTTON_TYPE_AJOUT = 1;
    private $BUTTON_TYPE_ENREGISTRER = 2;
    private $BUTTON_TYPE_ANNULER = 3;
    private $BUTTON_TYPE_SUPPRIMER = 4;
    private $BUTTON_TYPE_RETOUR = 5;


    private $header_barre = [];
    private $menu = [];
    private $userRoles = [];
    private $entites = [];

    private $entite = 'main';


    /**
     *
     * @param
     * @return
     */
    public function __construct()
    {
        $this->userRoles = RoleUser::liste();
        // dd($this->roles);

    }


    public function getConst($constante){
        return $this->$constante;
    }
    public function getEntites(){
        return $this->entites;
    }

    /**
     *
     * @param
     * @return
     */
    public function init($nomEntite = 'main')
    {
        $this->setEntite($nomEntite);
        $this->entites[$this->entite] = [
            'paras' => [],
            'view' => [
                'buttons' => [],
                'routes' => [],
                'routeNames' => [],
                'is_create' => false
            ]
        ];
        // detection des noms des menus à afficher et vérification de leur présence
        $this->menuCheck();
    }

    private function menuCheck()
    {
        Menu::check($this->userRoles);
    }

    /**
     *
     * @param
     * @return
     */
    public function initView($nomEntite = 'main')
    {
        $this->setEntite($nomEntite);
    }
    /**
     *
     * @param
     * @return
     */
    public function setEntite($nomEntite = 'main')
    {
        $this->entite = $nomEntite;
    }

    // ------------------------------------------------------- VIEW
    /**
     *
     * @param
     * @return
     */
    public function getTitre()
    {
        return  $this->entites[$this->entite]['view']['titre'];
    }

    /**
     *
     * @param
     * @return
     */
    public function getRoute($cible = 'grille')
    {
        return  $this->entites[$this->entite]['view']['routes'][$cible];
    }

    /**
     *
     * @param
     * @return
     */
    public function getRouteName($cible = 'grille')
    {
        return  $this->entites[$this->entite]['view']['routeNames'][$cible];
    }



    /**
     *
     * @param
     * @return
     */
    public function button_getLabel($id)
    {
        return isset($this->entites[$this->entite]['view']['buttons'][$id]['label']) ? $this->entites[$this->entite]['view']['buttons'][$id]['label'] : '';
    }

    /**
     *
     * @param
     * @return
     */
    public function button_getRouteName($id)
    {
        return isset($this->entites[$this->entite]['view']['buttons'][$id]['routeName']) ? $this->entites[$this->entite]['view']['buttons'][$id]['routeName'] : '';
    }

    /**
     *
     * @param
     * @return
     */
    public function button_getRoute($id)
    {
        return isset($this->entites[$this->entite]['view']['buttons'][$id]['route']) ? $this->entites[$this->entite]['view']['buttons'][$id]['route'] : '';
    }
    // ------------------------------------------------------- ENTITES

    /**
     *
     * @param
     * @return
     */
    public function setTitre(String $titre)
    {
        $this->entites[$this->entite]['view']['titre'] = $titre;
    }

    /**
     *
     * @param
     * @return
     */
    public function button_add($infos)
    {
        $this->entites[$this->entite]['view']['buttons'][$infos['id']] = $infos;
    }

    // ----------------- route

    /**
     *
     * @param
     * @return
     */
    public function route_add($cible = 'grille', $route)
    {
        $this->entites[$this->entite]['view']['routes'][$cible] = $route;
    }
    /**
     *
     * @param
     * @return
     */
    public function routeName_add($cible = 'grille', $routeName)
    {
        $this->entites[$this->entite]['view']['routeNames'][$cible] = $routeName;
    }

    /**
     *
     * @param
     * @return
     */
    public function setParas($paras)
    {
        $this->entites[$this->entite]['paras'] = $paras;
    }


    /**
     *
     *
     * @param
     * @return
     */
    public function form_setIsCreate($isCreate)
    {
        $this->entites[$this->entite]['form']['isCreate'] = $isCreate;
    }
    /**
     *
     *
     * @param
     * @return
     */
    public function form_isCreate()
    {
       return $this->entites[$this->entite]['form']['isCreate'] ;
    }

    /**
     *
     *  @param
     * @return
     */
    public function data_setList($listNom, $listData)
    {
        $this->entites[$this->entite]['lists'][$listNom] = $listData;
    }

    /**
     *
     * @param
     * @return
     */
    public function data_getList($nom)
    {
        return isset($this->entites[$this->entite]['lists'][$nom]) ? $this->entites[$this->entite]['lists'][$nom] : null;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function form_setHiddenValues($hiddens)
    {
        $this->entites[$this->entite]['form']['hiddens'] = $hiddens;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function form_getHiddenValues()
    {

        return isset($this->entites[$this->entite]['form']['hiddens']) ? $this->entites[$this->entite]['form']['hiddens'] : null;
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
    public function setData($arrayData)
    {
        foreach ($arrayData as $key => $value) {
            $this->entites[$this->entite]['form']['datas'][$key] =  $value;
        }
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
                    // $ret[$key] = old($key) ? old($key) : $elt;
                    $this->entites[$this->entite]['form']['datas'][$key] = old($key) ? old($key) : $elt;

                }
            }
        } else {
            dd("erreur");
        }
        // if (!isset($this->paras[$this->entree]['form'])) $this->paras[$this->entree]['form'] = [];
        // $this->entites[$this->entite]['form']['datas'] = $ret;
    }

/**
     *
     * @return
     */
    public function form_getData($champNom){
        return isset($this->entites[$this->entite]['form']['datas'][$champNom]) ? $this->entites[$this->entite]['form']['datas'][$champNom] : null;
    }

    /**
     *
     * @param
     * @return
     */
    public function processForView()
    {
        // foreach ($this->entites as $entite => $entites) {
        // }
        return $this->entites;

    }

    // -----------------------
    private function getTablePrincipale()
    {
        // return $this->paras[$this->entite]['table_principale'];
        return $this->entites[$this->entite]['paras']['table_principale'];
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
        $table = DB::select($requetePara['requete']);

        $requeteNb = $this->getRequete($entree, true);
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

        $limit = isset($_GET['limit']) ? $_GET['limit'] :  25;

        // Récupération de la chaine pour la recherche
        $search = isset($_GET['search']) && $_GET['search'] ?  '%' . $_GET['search'] . '%' : '';

        // Création SELECT
        $select = '';
        //  dd($this->entites[$this->entite]['paras']);
        foreach ($this->entites[$this->entite]['paras']['champs'] as $champ => $infoChamp) {
            $select .= $select ? ',' : '';
            $select .= isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] . ' as ' . $champ : $this->entites[$this->entite]['paras']['table_principale'] . '.' . $champ . ' as ' . $champ;
        }

        $offset = isset($_GET['offset']) ?  $_GET['offset'] : 0;
        // Création Sort
        if (isset($_GET['sort']) && $_GET['sort']) {
            $sort = isset($this->entites[$this->entite]['paras']['champs'][$_GET['sort']]['table']) ? $this->entites[$this->entite]['paras']['champs'][$_GET['sort']]['table'] . '.' . $this->entites[$this->entite]['paras']['champs'][$_GET['sort']]['champ_table'] : $this->entites[$this->entite]['paras']['table_principale'] . '.' . $_GET['sort'];
        } else {
            // echo $this->paras['champs'][$this->paras['sort_defaut']]['table'];
            $sort = isset($this->entites[$this->entite]['paras']['champs'][$this->entites[$this->entite]['paras']['sort_defaut']]['table']) ? $this->entites[$this->entite]['paras']['champs'][$this->entites[$this->entite]['paras']['sort_defaut']]['table'] . '.' . $this->entites[$this->entite]['paras']['champs'][$this->entites[$this->entite]['paras']['sort_defaut']]['champ_table'] : $this->entites[$this->entite]['paras']['table_principale'] . '.' . $this->entites[$this->entite]['paras']['sort_defaut'];
        }
        // Création Order
        $order = isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : $this->entites[$this->entite]['paras']['order_defaut'];


        // Création JOIN
        $join = '';
        foreach ($this->entites[$this->entite]['paras']['jointure'] as $jointure) {
            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
        }

        // Création orWhere  pour search
        $orWheres = '';
        if ($search) {
            foreach ($this->entites[$this->entite]['paras']['champs'] as $champ => $infoChamp) {
                $orWhereChamp = isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] : $this->entites[$this->entite]['paras']['table_principale'] . '.' . $champ;
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
                    if (isset($this->entites[$this->entite]['paras']['filtre'][$filtre]['jointure']) && $this->entites[$this->entite]['paras']['filtre'][$filtre]['jointure']) {
                        foreach ($this->entites[$this->entite]['paras']['filtre'][$filtre]['jointure'] as $jointure) {
                            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
                        }
                    }
                    $where = $where ? $where . ' && ' : $where;
                    $where .= $this->entites[$this->entite]['paras']['filtre'][$filtre]['champ'] . '=' . $value;
                }
            }
        }

        // Création Where FILTRE FIXE
        if (isset($_GET['filtre_fixe'])) {
            foreach ($_GET['filtre_fixe'] as $filtre => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $this->entites[$this->entite]['paras']['filtre_fixe'][$filtre] . '=' . $value;
            }
        }

        // Filtre permanent
        if (isset($this->entites[$this->entite]['paras']['filtre_permanent'])) {
            foreach ($this->entites[$this->entite]['paras']['filtre_permanent'] as $champ => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $champ . '=' . $value;
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
            $requete = 'select count(*) as nb from ' . $this->entites[$this->entite]['paras']['table_principale'] . ' ' . $join . $where;
        } else {
            $requete = 'select ' . $select . ' from ' . $this->entites[$this->entite]['paras']['table_principale'] . ' ' . $join . $where . ' order by ' . $sort . ' ' . $order . ' limit ' . $limit . ' offset ' . $offset;
        }
        return  ['requete' => $requete, 'offset' => $offset, 'limit' => $limit];
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
}
