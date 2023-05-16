<?php
namespace Rras3k\Sebconsole\Http\Controllers;

use App\Models\LogHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rras3k\SebconsoleRoot\facades\Core;
use App\Http\Controllers\Controller;


class LogHeadController extends Controller
{


    /**
     *
     *
     * @return
     */
    public function getPara()
    {
        return
            [

                'table_principale' => 'log_heads',
                'jointure' => [
                    ['type' => 'left join', 'table' => 'users', 'on' => 'users.id', 'cible' => 'log_heads.user_id'],

                ],
                'champs' => [
                    'id' => ['table' => 'log_heads', 'champ_table' => 'id'],
                    'user_id' => ['table' => 'log_heads', 'champ_table' => 'user_id'],
                    'user_id_str' => ['table' => 'users', 'champ_table' => 'name'],
                    'created_at' => ['table' => 'log_heads', 'champ_table' => 'created_at'],
                    'updated_at' => ['table' => 'log_heads', 'champ_table' => 'updated_at'],
                    'is_enable' => ['table' => 'log_heads', 'champ_table' => 'is_enable'],
                    'action' => ['table' => 'log_heads', 'champ_table' => 'action'],
                    'routeName' => ['table' => 'log_heads', 'champ_table' => 'routeName'],
                    'uri' => ['table' => 'log_heads', 'champ_table' => 'uri'],
                    'model_str' => ['table' => 'log_heads', 'champ_table' => 'id'],
                ],
                'filtre' => [
                    // 'auteur' => auteurs.id
                ],
                'filtre_fixe' => [
                ],
                'filtre_permanent' => [
                    'log_heads.is_enable' => 1
                ],
                'sort_defaut' => 'id',
                'order_defaut' => 'desc',

            ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // Titre
        Core::setTitre("log_heads");

        // Création boutons
        // Core::button_add(['id' => "ajouter", 'label' => "Ajouter log_heads", 'route' => route('LogHead_console.create'), 'type' => Core::getConst('BUTTON_TYPE_AJOUT'), 'icon' => '', "class" => ""]);

        // Route pour la grille
        Core::route_add('grille', route('rras3k.LogHead.listeBt'));


        // Paras
        Core::setParas($this->getPara());

        // Option de filtre


        // Process
        Core::processForView();

        return view('sebconsoleviews::LogHead_index', compact('data'));


    }

    public function listeBt()
    {
        Core::setParas($this->getPara());
        return Core::listeBootstrapTable('main');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit($modelId)
    {
        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // créationdu tableau pour le passage des paramètres annexes
        $data = array();

        // instanciation du modele
        $model = LogHead::find($modelId);

        // Titre de la page
        Core::setTitre("log_heads: Edition de " . $model->id);

        // Route pour update
        Core::routeName_add('update', 'LogHead_console.update');

        // Route pour update
        Core::routeName_add('edit', 'LogHead_console.edit');

        // Core::form_setHiddenValues([
        //     'formulaire_id' => $formulaire->_id
        // ]);

        Core::data_setList('users', User::getList());

        // Indique qu'on est en mode mise à jour
        Core::form_setIsCreate(false);

        // Passe les datas du modele pour les éditer
        Core::form_setData($model);

        // Process
        Core::processForView();

        return view('LogHead_console_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $modelId)
    {
        // dd($request);
        $validated = $request->validate([
            'user_id' => 'required',
            'action' => 'required',
            'routeName' => 'required',
            'uri' => 'required',
        ], $this->PersonaliseErreur());
        $model = LogHead::find($modelId);
        $model->user_id = $request->user_id;
        $model->action = $request->action;
        $model->routeName = $request->routeName;
        $model->uri = $request->uri;
        $model->save();
        return redirect(route('LogHead_console.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // créationdu tableau pour le passage des paramètres annexes
        $data = array();

        // Titre de la page
        Core::setTitre('Création LogHead');

        // Route pour store
        Core::routeName_add('store', 'LogHead_console.store');

        // Indique qu'on est en mode création
        Core::form_setIsCreate(true);

        Core::data_setList('users', User::getList());

        return view('LogHead_console_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // dd($request);

        // Validation
        $validated = $request->validate([
            'user_id' => 'required',
            'action' => 'required',
            'routeName' => 'required',
            'uri' => 'required',
        ], $this->PersonaliseErreur());

        $model = new LogHead();
        $model->user_id = $request->user_id;
        $model->action = $request->action;
        $model->routeName = $request->routeName;
        $model->uri = $request->uri;
        $model->save();
        return redirect(route('LogHead_console.index'));
    }

    private function PersonaliseErreur()
    {
        return [
            'user_id.required' => 'Ce champ est obligatoire',
            'action.required' => 'Ce champ est obligatoire',
            'routeName.required' => 'Ce champ est obligatoire',
            'uri.required' => 'Ce champ est obligatoire',
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy($modelId)
    {
        $model = LogHead::find($modelId);
        $model->is_enable = 0;
        $model->save();
        return redirect(route('LogHead_console.index'));
    }
}
