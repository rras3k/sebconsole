<?php

namespace Rras3k\console\app\Lib;

use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Storage;


class MenuMaker
{
    private $menu = [];

    public function __construct()
    {
        $this->menu = $this->initListe();
    }
    public function initListe()
    {
        // $droitsByRole = Auth::user()->liste();
        $droitsByRole = RoleUser::liste();
        //  dd($droitsByRole);
        $menus = config('console.menu');
        foreach ($menus as $ind => $menu) {
            $enable = false;
            foreach ($menu['droits'] as $roleId) {
                // $enable =  isset($droitsByRole[$roleId]) && $droitsByRole[$roleId] ? true : $enable || false;
                $enable =  isset($droitsByRole[$roleId]) && $droitsByRole[$roleId] ? true : $enable || false;
            }
            $menus[$ind]['enable'] = $enable;
        }
        // dd($menus);
        return $menus;
    }
    public function get()
    {
        return $this->menu;
    }
}
