<?php

namespace Rras3k\console\app\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;


class SbController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function aff($texte)
    {
        echo '<br/>' . $texte;
    }
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
    public function PrepareToCreate($table)
    {
        $ret = [];
        $colomns = DB::select("SELECT COLUMN_NAME,COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'coquinland-v2-dev' AND TABLE_NAME = 'urls' ORDER BY ORDINAL_POSITION");
        foreach ($colomns as $ind => $column) {
            $ret[$column->COLUMN_NAME] = $column->COLUMN_DEFAULT;
        }
        return $ret;
    }
    private function getRealArray($tmp)
    {
        $a = array();
        foreach ($tmp as $ind => $row) {
            $a[] = $row;
        }
        return $a;
    }

    public function listeBootstrapTable($para = null)
    {
        // dd($para);
        $requetePara = $this->getRequete($para);
        $requeteNb = $this->getRequeteNb($para);
        // dd($para);
        //  dd($requetePara['requete']);
        $table = DB::select($requetePara['requete']);
        $nbRecords = DB::select($requeteNb['requete'])[0]->nb;
        // dd($nbRecords);
        // $nbRecords = count($table);
        // $table = array_slice($table, $requetePara['offset'], $requetePara['limit']);
        return response()->json(array('total' => $nbRecords, 'totalNotFiltered' => $nbRecords, 'rows' => $this->getRealArray($table)));
    }
    public function getRequeteNb($para = null)
    {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : (isset($para['limit']) ? $_GET['limit'] : 25);

        // Récupération de la chaine pour la revherche
        $search = isset($_GET['search']) && $_GET['search'] ?  '%' . $_GET['search'] . '%' : '';

        // Création SELECT
        $select = '';
        foreach ($para['champs'] as $champ => $infoChamp) {
            $select .= $select ? ',' : '';
            $select .= isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] . ' as ' . $champ : $para['table_principale'] . '.' . $champ . ' as ' . $champ;
        }

        $offset = isset($_GET['offset']) ?  $_GET['offset'] : 0;
        // Création Sort
        if (isset($_GET['sort']) && $_GET['sort']) {
            $sort = isset($para['champs'][$_GET['sort']]['table']) ? $para['champs'][$_GET['sort']]['table'] . '.' . $para['champs'][$_GET['sort']]['champ_table'] : $para['table_principale'] . '.' . $_GET['sort'];
        } else {
            // echo $para['champs'][$para['sort_defaut']]['table'];
            $sort = isset($para['champs'][$para['sort_defaut']]['table']) ? $para['champs'][$para['sort_defaut']]['table'] . '.' . $para['champs'][$para['sort_defaut']]['champ_table'] : $para['table_principale'] . '.' . $para['sort_defaut'];
        }
        // Création Order
        $order = isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : $para['order_defaut'];


        // Création JOIN
        $join = '';
        foreach ($para['jointure'] as $jointure) {
            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
        }

        // Création orWhere  pour search
        $orWheres = '';
        if ($search) {
            foreach ($para['champs'] as $champ => $infoChamp) {
                $orWhereChamp = isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] : $para['table_principale'] . '.' . $champ;
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
                    $where = $where ? $where . ' && ' : $where;
                    $where .= $para['filtre'][$filtre] . '=' . $value;
                }
            }
        }
        // Création Where FILTRE FIXE
        if (isset($_GET['filtre_fixe'])) {
            foreach ($_GET['filtre_fixe'] as $filtre => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $para['filtre_fixe'][$filtre] . '=' . $value;
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
        // dd($where);
        // dd($offset, $limit);
        $requete = 'select count(*) as nb from ' . $para['table_principale'] . ' ' . $join . $where;

        return  ['requete' => $requete, 'offset' => $offset, 'limit' => $limit];
    }
    public function getRequete($para = null)
    {
        // dd($para);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : (isset($para['limit']) ? $_GET['limit'] : 25);

        // Récupération de la chaine pour la revherche
        $search = isset($_GET['search']) && $_GET['search'] ?  '%' . $_GET['search'] . '%' : '';

        // Création SELECT
        $select = '';
        foreach ($para['champs'] as $champ => $infoChamp) {
            $select .= $select ? ',' : '';
            $select .= isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] . ' as ' . $champ : $para['table_principale'] . '.' . $champ . ' as ' . $champ;
        }

        $offset = isset($_GET['offset']) ?  $_GET['offset'] : 0;
        // Création Sort
        if (isset($_GET['sort']) && $_GET['sort']) {
            $sort = isset($para['champs'][$_GET['sort']]['table']) ? $para['champs'][$_GET['sort']]['table'] . '.' . $para['champs'][$_GET['sort']]['champ_table'] : $para['table_principale'] . '.' . $_GET['sort'];
        } else {
            // echo $para['champs'][$para['sort_defaut']]['table'];
            $sort = isset($para['champs'][$para['sort_defaut']]['table']) ? $para['champs'][$para['sort_defaut']]['table'] . '.' . $para['champs'][$para['sort_defaut']]['champ_table'] : $para['table_principale'] . '.' . $para['sort_defaut'];
        }
        // Création Order
        $order = isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : $para['order_defaut'];


        // Création JOIN
        $join = '';
        foreach ($para['jointure'] as $jointure) {
            $join .= ' ' . $jointure['type'] . ' ' . $jointure['table'] . ' on ' . $jointure['on'] . ' = ' . $jointure['cible'];
        }

        // Création orWhere  pour search
        $orWheres = '';
        if ($search) {
            foreach ($para['champs'] as $champ => $infoChamp) {
                $orWhereChamp = isset($infoChamp['table']) ? $infoChamp['table'] . '.' . $infoChamp['champ_table'] : $para['table_principale'] . '.' . $champ;
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
                    $where = $where ? $where . ' && ' : $where;
                    $where .= $para['filtre'][$filtre] . '=' . $value;
                }
            }
        }
        // Création Where FILTRE FIXE
        if (isset($_GET['filtre_fixe'])) {
            foreach ($_GET['filtre_fixe'] as $filtre => $value) {
                $where = $where ? $where . ' && ' : $where;
                $where .= $para['filtre_fixe'][$filtre] . '=' . $value;
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
        // dd($where);
        // dd($offset, $limit);
        $requete = 'select ' . $select . ' from ' . $para['table_principale'] . ' ' . $join . $where . ' order by ' . $sort . ' ' . $order . ' limit '.$limit.' offset '.$offset;

        return  ['requete' => $requete, 'offset' => $offset, 'limit' => $limit];

        // dd($requete);
        // $table = DB::select($requete);
        // $nbRecords = count($table);
        // $table = array_slice($table, $offset, $limit);
        // return response()->json(array('total' => $nbRecords, 'totalNotFiltered' => $nbRecords, 'rows' => $this->getRealArray($table)));
    }
}
