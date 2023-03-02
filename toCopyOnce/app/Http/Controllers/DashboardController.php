<?php

namespace App\Http\Controllers;

use Rras3k\SebconsoleRoot\facades\Core;




class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $data = [];
        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // Titre
        Core::setTitre("dashBoard");

        return view('dashboard-show', compact('data'));
    }
    public function getPara()
    {
    }
}
