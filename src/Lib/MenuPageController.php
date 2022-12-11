<?php

namespace Rras3k\Sebconsole\Lib;



use Illuminate\Support\Facades\Route;



class MenuPageController 
{


    private $menus;

    public function __construct(){
        $this->menus = config('sebconsole.menu_page');
    }

    private $values = []; // TODO

    public function addId($champId, $value, $para_url = null)
    {
        $this->values[$champId] = ['value_para' => $para_url, 'value_code' => $value];
    }

    public static function addEntree($champId, $route, $titre, $icon)
    {
        self::$menus[] = ['champ_id' => $champId, 'route' => $route, 'titre' => $titre, 'icon' => $icon];
    }

    public function getParaMenu()
    {
        $ret = [];
        foreach ($this->menus as $menu) {
            if (Route::currentRouteName() != $menu['route'] && (isset($this->values[$menu['champ_id']]['value_code']) || isset($this->values[$menu['champ_id']]['value_para']))) {
                $para ='';
                if($this->values[$menu['champ_id']]['value_para'] ){
                    $para = '/'.  $this->values[$menu['champ_id']]['value_para'];
                }
                if (isset($menu['condition']) && isset($this->values[$menu['condition']['champ']]['value_code'])) {
                    switch ($menu['condition']['operateur']) {
                        case '==':
                            if ($this->values[$menu['condition']['champ']]['value_code'] == $menu['condition']['value']) {
                                $ret[] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $this->values[$menu['champ_id']]['value_code']). $para, 'classIcon' => 'fa-solid' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                            }
                            break;
                    }
                } else {
                    $ret[] = ['titre' => $menu['titre'], 'url' => route($menu['route'], $this->values[$menu['champ_id']]['value_code']). $para, 'classIcon' => 'fa-solid ' . $menu['icon'], 'class' => isset($menu['class']) ? $menu['class'] : ''];
                }
            }
        }
        return $ret;
    }
}
