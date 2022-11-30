<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use Illuminate\Http\Request;
use Rras3k\Sebconsole\Http\Controllers\SbController;
use Illuminate\Support\Facades\View;



class UserController extends SbController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        $data = array();
        return view('sebconsoleviews::user-index', compact('data'));
    }
    public function listeBt()
    {
        $para = [
            'table_principale' => 'users',
            'jointure' => [
            ],
            'champs' => [
                'id' => ['table' => 'users', 'champ_table' => 'id'],
                'name' => ['table' => 'users', 'champ_table' => 'name']
            ],
            'filtre' => [
            ],
            'filtre_fixe' => [],
            'sort_defaut' => 'id',
            'order_defaut' => 'asc',
        ];

        return $this->listeBootstrapTable($para);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
