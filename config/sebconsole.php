<?php

use App\Models\Role;


return [
    'menu_affichage_liste_icons' => 'liste_icons_1',
    'menu_affichage_vertical' => 'vertical_1',
    'menu_affichage_horizontal' => 'horizontal_1',
    'menu' => [
        // Menu de la sidebar. Role::ROOT, Role::ADMIN, Role::MEMBRE_1, Role::MEMBRE_2, ...
        ['label' => 'Système', 'route' => '', 'icon' => '', 'droits' => null, 'items' => [
            ['label' => 'Génération MVC', 'route' => 'genereMvc.show', 'icon' => 'bi bi-person', 'droits' => [Role::ROOT]],
        ]],
        ['label' => 'Développement', 'route' => '', 'icon' => '', 'droits' => null, 'items' => [
            ['label' => 'Pages dev', 'route' => 'page-pasgit.index', 'icon' => 'fa-solid fa-city', 'droits' => [Role::ADMIN]],

        ]],
        ['label' => 'Nouvel ajout', 'route' => '', 'icon' => '', 'droits' => null, 'items' => []]
    ]
];
