<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use Illuminate\Http\Request;
use Rras3k\Sebconsole\Http\Controllers\SbController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\route;



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
        // $data['route'] = route('user.listeBt').$this->filtreUrl();
        $data['route'] = route('user.listeBt');
        $data['rras3k'] = $this->dataToView();
        return view('sebconsoleviews::user-index', compact('data'));
    }
    public function getPara(){
        return [
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
                    'champToStr' => 'roles.nom',
                    'jointure'=>[
                        ['type' => 'left join', 'table' => 'role_user', 'on' => 'role_user.user_id', 'cible' => 'users.id'],
                        ['type' => 'left join', 'table' => 'roles', 'on' => 'roles.id', 'cible' => 'role_user.role_id'],
                    ]
                ]
            ],
            'filtre_fixe' => [],
            'sort_defaut' => 'id',
            'order_defaut' => 'asc',
        ];
    }
    public function listeBt()
    {
        return $this->listeBootstrapTable();
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
