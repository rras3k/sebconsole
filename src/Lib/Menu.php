<?php

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\Auth;

use Rras3k\SebconsoleRoot\facades\RoleUser;

use Illuminate\Support\Facades\Storage;
use App\Models\Role;



class Menu
{
    private $menu = [];
    private $prefix = null;
    private $props = [];
    private $droitUser = [];
    private $menuInfos = [];
    const PATH_MENU = 'private/menus/';

    const MENU_TO_SHOW_LISTE_ICONS = 1;
    const MENU_TO_SHOW_VERTICAL = 2;
    const MENU_TO_SHOW_HORIZONTAL = 3;

    public function __construct()
    {
        // $this->menu = $this->initListe();
        // $this->droitUser = RoleUser::liste();
        //     $tmp = config('sebconsole.menu');
        //     $this->menu = $tmp['items'];
        //     $this->props = $tmp['props'];
        //
    }

    public function check($userRoles)
    {
        // $this->droitUser = $userRoles;
        $this->prefix = $this->getPrefixMenu($userRoles);

        $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS] = ["view_name" => config('sebconsole.menu_affichage_liste_icons'), "is_enable" => false, "is_toGenerate" => false];
        if ($this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["view_name"]) {
            $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["is_enable"] = true;
            $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["pathFile"] = self::PATH_MENU . $this->prefix . '_' . $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["view_name"] . '.html';
        }
        $this->menuInfos[self::MENU_TO_SHOW_VERTICAL] = ["view_name" => config('sebconsole.menu_affichage_vertical'), "is_enable" => false, "is_toGenerate" => false];
        if ($this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["view_name"]) {
            $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["is_enable"] = true;
            $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["pathFile"] = self::PATH_MENU . $this->prefix . '_' . $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["view_name"] . '.html';
        }
        $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL] = ["view_name" => config('sebconsole.menu_affichage_horizontal'), "is_enable" => false, "is_toGenerate" => false];
        if ($this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["view_name"]) {
            $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["is_enable"] = true;
            $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["pathFile"] = self::PATH_MENU . $this->prefix . '_' . $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["view_name"] . '.html';
        }
        $this->checkMenusForRoles($userRoles);
    }


    public function checkMenusForRoles($listeRole)
    {
        $isGeneration = false;
        // $isGeneration = true;


        // pour le menu sous forme de liste d'icons
        if ($this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["is_enable"]) {
            if (!Storage::exists($this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["pathFile"])) {
                $isGeneration = $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["is_toGenerate"] = true;
            }
        }

        // pour le menu vertical
        if ($this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["is_enable"]) {
            if (!Storage::exists($this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["pathFile"])) {
                $isGeneration = $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["is_toGenerate"] = true;
            }
        }

        // pour le menu horizontal
        if ($this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["is_enable"]) {
            if (!Storage::exists($this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["pathFile"])) {
                $isGeneration = $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["is_toGenerate"] = true;
            }
        }

        // génération si besoin
        if ($isGeneration) {
            $this->droitUser = $listeRole;
            $this->menu = config('sebconsole.menu');
            // dd($this->menu);
            $this->initIsEnable($this->menu);

            if ($this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["is_toGenerate"]) {
                $fct = 'genereMenu_' . $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["view_name"];
                $this->$fct($this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["view_name"], $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["pathFile"]);
            }
            if ($this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["is_toGenerate"]) {
                $fct = 'genereMenu_' . $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["view_name"];
                $this->$fct($this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["view_name"], $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["pathFile"]);
            }

            if ($this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["is_toGenerate"]) {
                $fct = 'genereMenu_' . $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["view_name"];
                $this->$fct($this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["view_name"], $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["pathFile"]);
            }
        }
    }

    private function getPrefixMenu($listeRole)
    {
        $prefix = "";
        foreach ($listeRole as $roleId => $info) {
            $prefix = $prefix ? $prefix . '_' . $roleId : $roleId;
        }
        return $prefix;
    }


    public function delMenus()
    {
        Storage::deleteDirectory(self::PATH_MENU);
    }

    // ----------------------------------------------------------------- Appel Menu
    public function getMenu_listeIcons_pathFile()
    {
        return storage_path('app') . '/' . $this->menuInfos[self::MENU_TO_SHOW_LISTE_ICONS]["pathFile"];
    }
    public function getMenu_vertical_pathFile()
    {
        return storage_path('app') . '/' . $this->menuInfos[self::MENU_TO_SHOW_VERTICAL]["pathFile"];
    }
    public function getMenu_horizontal_pathFile()
    {
        return storage_path('app') . '/' . $this->menuInfos[self::MENU_TO_SHOW_HORIZONTAL]["pathFile"];
    }

    // ----------------------------------------------------------------- Génération Menu

    // ---- vertical_1
    private function genereMenu_vertical_1($viewName, $pathFile)
    {
        // dd($viewName, $pathFile);
        $codeHtml = '';
        $this->genereMenu_vertical_1_prepare($this->menu, $codeHtml);
        $codeHtml = '<div class="§_vertical_1">' . $codeHtml . '</div>';

        Storage::disk('local')->put($pathFile, $codeHtml);
    }
    private function genereMenu_vertical_1_prepare($menu, &$codeHtml)
    {
        // dd($menu);
        $this->genereMenu_vertical_1_recursif($menu, $codeHtml);
        // foreach ($menu as $ind => $elts) {
        //     if ($elts['is_enable']) {
        //         $codeHtml .= $codeHtml ? '</div>' : '';
        //         $codeHtml .= '<div><span>' . $elts['label'] . '</span>';
        //         if (isset($elts['items']) && $elts['items']) $this->genereMenu_vertical_1_recursif($elts['items'], $codeHtml);
        //     }
        // }
        // $codeHtml .= $codeHtml ? '</div>' : '';
    }
    private function genereMenu_vertical_1_recursif($menu, &$codeHtml)
    {
        foreach ($menu as $ind => $elts) {
            if (isset($elts['is_enable']) && $elts['is_enable']) {

                if (isset($elts['route']) && $elts['route']) {
                    $href = $elts['route'] ? route($elts['route']) : "#";

                    $codeHtml .= '<a href="' . $href . '">';
                    if (isset($elts['icon']) && $elts['icon'])
                        $codeHtml .= '<i class="' . $elts['icon'] . '"></i>';
                    if (isset($elts['label']) && $elts['label'])
                        $codeHtml .= $elts['label'];
                    $codeHtml .= '</a>';
                }

                if (isset($elts['items']) && $elts['items'])
                    $this->genereMenu_vertical_1_recursif($elts['items'], $codeHtml);
            }
        }
    }



    // ---- Liste icon : liste_icons_1
    private function genereMenu_liste_icons_1($viewName, $pathFile)
    {
        // dd($viewName, $pathFile);
        $codeHtml = '';
        $this->genereMenu_liste_icon_1_prepare($this->menu, $codeHtml);
        $codeHtml = '<div class="§_menu_liste_icons_1">' . $codeHtml . '</div>';

        Storage::disk('local')->put($pathFile, $codeHtml);
    }
    private function genereMenu_liste_icon_1_prepare($menu, &$codeHtml)
    {

        foreach ($menu as $ind => $elts) {
            if (isset($elts['is_enable']) && $elts['is_enable']) {
                $codeHtml .= $codeHtml ? '</div>' : '';
                $codeHtml .= '<div><span>' . $elts['label'] . '</span>';
                if (isset($elts['items']) && $elts['items'])
                    $this->genereMenu_liste_icon_1_recursif($elts['items'], $codeHtml);
            }
        }
        $codeHtml .= $codeHtml ? '</div>' : '';
    }
    private function genereMenu_liste_icon_1_recursif($menu, &$codeHtml)
    {
        foreach ($menu as $ind => $elts) {
            if (isset($elts['is_enable']) && $elts['is_enable']) {
                $href = $elts['route'] ? route($elts['route']) : "#";

                if (isset($elts['route']) && $elts['route'])
                    $codeHtml .= '<a href="' . $href . '">';
                if (isset($elts['icon']) && $elts['icon'])
                    $codeHtml .= '<i class="' . $elts['icon'] . '"></i></a>';
                if (isset($elts['route']) && $elts['route'])
                    $codeHtml .= '</a>';

                if (isset($elts['items']) && $elts['items'])
                    $this->genereMenu_liste_icon_1_recursif($elts['items'], $codeHtml);
            }
        }
    }

    // ---- horizontal_1
    private function genereMenu_horizontal_1($viewName, $pathFile)
    {
        // dd($viewName, $pathFile);
        $codeHtml = '<ul>' . "\n";
        $this->genereMenu_horizontal_1_prepare($this->menu, $codeHtml);
        // $codeHtml = '<div class="§_horizopntal_1">' . $codeHtml . '</div>' . "\n";
        // $codeHtml .= $codeHtml;
        $codeHtml .= '</ul>' . "\n";
        // dd($codeHtml);
        Storage::disk('local')->put($pathFile, $codeHtml);
    }
    private function genereMenu_horizontal_1_prepare($menu, &$codeHtml)
    {
        // dd($menu);
        $niveau = 0;
        $this->genereMenu_horizontal_1_recursif($menu, $codeHtml, $niveau);
        // foreach ($menu as $ind => $elts) {
        //     if ($elts['is_enable']) {
        //         $codeHtml .= $codeHtml ? '</div>' : '';
        //         $codeHtml .= '<div><span>' . $elts['label'] . '</span>';
        //         if (isset($elts['items']) && $elts['items']) $this->genereMenu_vertical_1_recursif($elts['items'], $codeHtml);
        //     }
        // }
        // $codeHtml .= $codeHtml ? '</div>' : '';
    }
    private function genereMenu_horizontal_1_recursif($menu, &$codeHtml, &$niveau)
    {
        // dump($menu);
        foreach ($menu as $ind => $elts) {
            if (isset($elts['is_enable']) && $elts['is_enable']) {
                $niveau++;
                // dump($elts['label'], $niveau);

                // if (isset($elts['route']) && $elts['route']) {
                $codeHtml .= '<li>' . "\n";
                $href = $elts['route'] ? route($elts['route']) : "#";
                $codeHtml .= '<a href="' . $href . '">' . "\n";
                $codeHtml .= '<span>';
                if (isset($elts['icon']) && $elts['icon'])
                    $codeHtml .= '<i class="' . $elts['icon'] . '"></i>' . "\n";
                if (isset($elts['label']) && $elts['label'])
                    $codeHtml .= $elts['label'];
                $codeHtml .= '</span>';
                // $codeHtml.= '<i class="bi bi-arrow-right-circle-fill"></i>'; // a supprimer
                // $codeHtml .= '</a>' . "\n";
                // }
                $codeHtmlTmp = '';

                if (isset($elts['items']) && $elts['items']) {
                    // dump("sous-menu !!");
                    $codeHtmlTmp .= '<ul>' . "\n";
                    $this->genereMenu_horizontal_1_recursif($elts['items'], $codeHtmlTmp, $niveau);
                    $codeHtmlTmp .= '</ul>' . "\n";
                    // $codeHtml .= '<ul>' . "\n";
                    // $this->genereMenu_horizontal_1_recursif($elts['items'], $codeHtml);
                    // $codeHtml .= '</ul>' . "\n";
                }
                if ($codeHtmlTmp && $niveau > 1) {
                    // if ($codeHtmlTmp  ) {
                    $codeHtml .= '<i class="bi bi-arrow-right-circle-fill"></i>'; // a supprimer
                } elseif($codeHtmlTmp) {
                    // $codeHtml .= '<i class="bi bi-arrow-down-circle-fill"></i>'; // a supprimer
                }
                $codeHtml .= '</a>' . "\n";

                $codeHtml .= $codeHtmlTmp;
                $codeHtml .= '</li>' . "\n";

                $niveau--;
            }
            // dump($codeHtml);
        }
    }
    // private function genereMenu_horizontal_1_recursif($menu, &$codeHtml)
    // {
    //     foreach ($menu as $ind => $elts) {
    //         if (isset($elts['is_enable']) && $elts['is_enable']) {

    //             // if (isset($elts['route']) && $elts['route']) {
    //                 $href = $elts['route'] ? route($elts['route']) : "#";
    //                 $codeHtml .= '<a href="' . $href . '">' . "\n";
    //                 if (isset($elts['icon']) && $elts['icon'])
    //                     $codeHtml .= '<i class="' . $elts['icon'] . '"></i>' . "\n";
    //                 if (isset($elts['label']) && $elts['label'])
    //                     $codeHtml .= $elts['label'];
    //                 $codeHtml .= '</a>' . "\n";
    //             // }

    //             if (isset($elts['items']) && $elts['items'])
    //                 $this->genereMenu_horizontal_1_recursif($elts['items'], $codeHtml);
    //         }
    //     }
    // }










    public function initIsEnable(&$menu)
    {
        $is_enable = true;
        foreach ($menu as $ind => &$elts) {
            if (isset($elts['droits']) && $elts['droits']) { // cas où il y a des droits
                $elts['is_enable'] = $this->hasRight($elts['droits']);
                $is_enable = false || $elts['is_enable'];
            }
            if (isset($elts['items']) && $elts['items']) { // pour tous les éléments dans items
                $is_enable = $this->initIsEnable($elts['items']);
                $elts['is_enable'] = $is_enable;
            }
        }
        return $is_enable;
    }


    // public function genereAll()
    // {
    //     dd(Auth::user()->id);
    //     $listRoles = RoleUser::liste();
    //     dd($listRoles);
    // }

    // public function initListe()
    // {
    //     $droitsByRole = RoleUser::liste();
    //     $menus = config('sebconsole.menu');
    //     foreach ($menus as $ind => $menu) {
    //         $enable = false;
    //         foreach ($menu['droits'] as $roleId) {
    //             $enable =  isset($droitsByRole[$roleId]) && $droitsByRole[$roleId] ? true : $enable || false;
    //         }
    //         $menus[$ind]['enable'] = $enable;
    //     }
    //     return $menus;
    // }



    private function hasRight($menuDroits)
    {
        foreach ($menuDroits as $roleId) {
            if (isset($this->droitUser[$roleId]) && $this->droitUser[$roleId])
                return true;
        }
        return false;
    }

    // private function getNameRolesPRefix($droits)
    // {
    //     $ret = '_';
    //     foreach ($droits as $roleId) {
    //         $ret .= $roleId . '_';
    //     }
    //     return $ret;
    // }

    // private function genereMenu_icon($fichier)
    // {
    //     View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
    //     $data = $this->menu;
    //     $code = View('sebconsoleviews::genereMenu.mode_icon', compact('data'))->render();
    //     Storage::disk('local')->put($this->pathMenu . $fichier, $code);
    // }


    // public function get()
    // {
    //     $this->initListe2($this->menu);
    //     $prefix = $this->getNameRolesPRefix($this->droitUser);
    //     $this->genereMenu_icon($prefix . 'icon.html');
    //     // dump($this->initListe2($this->menu));
    //     // dd($this->menu);
    //     return $this->menu;
    // }
}
