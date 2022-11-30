<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use Rras3k\Sebconsole\Models\LogHead;
use Rras3k\Sebconsole\Models\LogType;
use Illuminate\Http\Request;
use Rras3k\Sebconsole\Http\Controllers\SbController;
use Illuminate\Support\Facades\View;





class LogHeadController extends SbController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        $data = array();
        $data['log_types'] = LogType::liste();
        return view('sebconsoleviews::logHead-index', compact('data'));

    }
    public function listeBt()
    {
        $para = [
            'table_principale' => 'log_heads',
            'jointure' => [
                ['type' => 'left join', 'table' => 'log_types', 'on' => 'log_types.id', 'cible' => 'log_heads.log_type_id'],
                ['type' => 'left join', 'table' => 'users', 'on' => 'users.id', 'cible' => 'log_heads.user_id']
            ],
            'champs' => [
                'id' => ['table' => 'log_heads', 'champ_table' => 'id'],
                'favori' => ['table' => 'log_heads', 'champ_table' => 'favori'],
                'texte' => ['table' => 'log_heads', 'champ_table' => 'texte'],
                'created_at' => ['table' => 'log_heads', 'champ_table' => 'created_at'],
                'user_nom' => ['table' => 'users', 'champ_table' => 'name'],
                'log_type_nom' => ['table' => 'log_types', 'champ_table' => 'nom']
            ],
            'filtre' => [
                'log_types' => 'log_types.id'
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
     * @param  \App\Models\LogHead  $logHead
     * @return \Illuminate\Http\Response
     */
    public function show(LogHead $logHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogHead  $logHead
     * @return \Illuminate\Http\Response
     */
    public function edit(LogHead $logHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogHead  $logHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogHead $logHead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogHead  $logHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogHead $logHead)
    {
        //
    }
}
