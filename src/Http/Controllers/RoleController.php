<?php

namespace Rras3k\Sebconsole\Http\Controllers;


use Rras3k\Sebconsole\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Rras3k\Sebconsole\Http\Controllers\SbController;




class RoleController extends SbController
{
    public function getPara()
    {
        return
        [
            'table_principale' => 'roles',
            'jointure' => [],
            'champs' => [
                'id' => ['table' => 'roles', 'champ_table' => 'id'],
                'name' => ['table' => 'roles', 'champ_table' => 'nom'],
                'fonction' => ['table' => 'roles', 'champ_table' => 'fonction']
            ],
            'filtre' => [],
            'filtre_fixe' => [],
            'sort_defaut' => 'id',
            'order_defaut' => 'asc',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $this->getInfoTable('roles');
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = array();       
        return view('sebconsoleviews::role-index', compact('data'));
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = array();
        $data['form'] = [];
        $data['isCreate'] = false;
        $data['form']['role'] = $this->PrepareToEdit($role);

        $this->menuPage_add('role_id', null, '?filtre[role]=' . $role->id);
        $data['menu_page'] = $this->menuPage_get();

        return view('sebconsoleviews::role-edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        dump($role);
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
