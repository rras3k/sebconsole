<?php
// use App\Models\Role;
// use Rras3k\Sebconsole\app\Models\Role;
// use Rras3k\Sebconsole\Lib\RoleUser;
use Rras3k\Sebconsole\Models\Role;


return [
    'affiche_logo' => true,         // Affichage du logo /public/img/logo.png
    'affiche_icon_libre' => true,  // Affichage des icons des menus de façon inline
    'menu_accordeon' => true,      // Affichage des rubriques avec accordeon
    'url_doc' => "https://docs.google.com/document/d/1qVCxkKHd2MzgfbUnRfAHSwBNjOFDLcY0o2yCiI5Nqsg/edit",
    'menu' => [ // Menu de la sidebar. Role::ROOT, Role::ADMIN, Role::MEMBRE_1, Role::MEMBRE_2, ...
        // Système
        ['rubrique' => 'Système', 'nom' => 'Users', 'route' => 'user.index', 'icon' => 'bi bi-person', 'droits' => [Role::ADMIN]],
        ['rubrique' => 'Système', 'nom' => 'Roles', 'route' => 'role.index', 'icon' => 'bi bi-person', 'droits' => [Role::ADMIN]],
        ['rubrique' => 'Système', 'nom' => 'Groupe Logs', 'route' => 'logHead.index', 'icon' => 'fa-solid fa-ellipsis-vertical', 'droits' => [Role::ADMIN]],
        ['rubrique' => 'Système', 'nom' => 'Logs', 'route' => 'logDetail.index', 'icon' => 'fa-solid fa-braille', 'droits' => [Role::ADMIN]],

        // Localisation
        //[ 'rubrique' => 'Localisation', 'nom' => 'Villes', 'route' => 'logDetail.index', 'icon' => 'fa-solid fa-city', 'droits'=> [Role::ADMIN]],

        // Root
        ['rubrique' => 'Root', 'nom' => 'Générations', 'route' => 'generation.index', 'icon' => 'fa-solid fa-arrows-spin', 'droits' => [Role::ROOT]],

        // dev
        ['rubrique' => 'Dev', 'nom' => 'Pages dev', 'route' => 'page-pasgit.index', 'icon' => 'fa-solid fa-city', 'droits' => [Role::ADMIN]],

    ],
    'menu_page' => [
        ['champ_id' => 'role_id', 'route' => 'user.index', 'titre' => 'Users même rôle', 'icon' => 'fa-plus', 'sans-val' => true, 'para_url' => ''],  // Liste des users ayant ce role

    ]
];
