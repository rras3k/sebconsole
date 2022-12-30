<?php

namespace Rras3k\Sebconsole\Http\Controllers;


use Rras3k\Sebconsole\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Rras3k\Sebconsole\Http\Controllers\SbController;




class RoleController extends SbController
{
    public function __construct()
    {
        $this->setEntree('main');
        parent::__construct();
    }

    public function getPara()
    {
        return
            [
                'main' => [
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
                ]
            ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = array();
        $data['rras3k'] = $this->dataToView();
        return view('sebconsoleviews::role-index', compact('data'));
    }

    public function listeBt()
    {
        return $this->listeBootstrapTable('main');
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
        // View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');
        $data = array();
        $data['route'] = route('role.update', $role->id);

        // dd($data);
        $this->page_setTitre("Edition du rôle: " . $role->nom);
        $this->form_setHiddenValues([
            'formulaire_page_id' => $role->id
        ]);
        $this->form_setIsCreate(false);
        $this->form_setData($role);
        $data['rras3k'] = $this->dataToView();

        return view('sebconsoleviews::role-edit', compact('data'));
    }

    private function PersonaliseErreur()
    {
        return [
            'nom.required' => 'Ce champ est obligatoire',
            'fonction.required' => 'Ce champ est obligatoire',
        ];
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
        $validated = $request->validate([
            'nom' => 'required',
            'fonction' => 'required',

        ], $this->PersonaliseErreur());
        $role->nom = $request->nom;
        $role->fonction = $request->fonction;
        $role->save();
         return redirect()->route('role.index');
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
