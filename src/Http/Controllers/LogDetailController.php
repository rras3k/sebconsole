<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use Rras3k\Sebconsole\Models\LogDetail;
use Illuminate\Http\Request;
use Rras3k\Sebconsole\Http\Controllers\SbController;
use Illuminate\Support\Facades\View;



class LogDetailController extends SbController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = array();
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        return view('sebconsoleviews::logDetail-index', compact('data'));

    }
    public function listeBt()
    {
        $para = [
            'table_principale' => 'log_details',
            'jointure' => [
                ['type' => 'left join', 'table' => 'users', 'on' => 'users.id', 'cible' => 'log_details.user_id']
            ],
            'champs' => [
                'id' => ['table' => 'log_details', 'champ_table' => 'id'],
                'texte' => ['table' => 'log_details', 'champ_table' => 'texte'],
                'created_at' => ['table' => 'log_details', 'champ_table' => 'created_at'],
                'user_nom' => ['table' => 'users', 'champ_table' => 'name']
            ],
            'filtre' => [
                // 'log_types' => 'log_types.id'
            ],
            'filtre_fixe' => [],
            'sort_defaut' => 'id',
            'order_defaut' => 'desc',
        ];
        // dd($this->getRequete($para));
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
     * @param  \App\Models\LogDetail  $logDetail
     * @return \Illuminate\Http\Response
     */
    public function show(LogDetail $logDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogDetail  $logDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(LogDetail $logDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogDetail  $logDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogDetail $logDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogDetail  $logDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogDetail $logDetail)
    {
        //
    }
}
