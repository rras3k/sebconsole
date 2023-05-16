<?php
namespace Rras3k\Sebconsole\Http\Controllers;

use App\Models\LogDetail;
use App\Models\LogHead;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rras3k\SebconsoleRoot\facades\Core;
use App\Http\Controllers\Controller;



class LogDetailController extends Controller
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

                'table_principale' => 'log_details',
                'jointure' => [
                    ['type' => 'left join', 'table' => 'log_heads', 'on' => 'log_heads.id', 'cible' => 'log_details.log_head_id'],
                    ['type' => 'left join', 'table' => 'roles', 'on' => 'roles.id', 'cible' => 'log_details.role_id'],

                ],
                'champs' => [
                    'id' => ['table' => 'log_details', 'champ_table' => 'id'],
                    'log_head_id' => ['table' => 'log_details', 'champ_table' => 'log_head_id'],
                    'log_head_id_str' => ['table' => 'log_heads', 'champ_table' => 'id'],
                    'texte' => ['table' => 'log_details', 'champ_table' => 'texte'],
                    'created_at' => ['table' => 'log_details', 'champ_table' => 'created_at'],
                    'updated_at' => ['table' => 'log_details', 'champ_table' => 'updated_at'],
                    'is_enable' => ['table' => 'log_details', 'champ_table' => 'is_enable'],
                    'role_id' => ['table' => 'log_details', 'champ_table' => 'role_id'],
                    'role_id_str' => ['table' => 'roles', 'champ_table' => 'nom'],
                    'model_str' => ['table' => 'log_details', 'champ_table' => 'id'],
                ],
                'filtre' => [
                    // 'auteur' => auteurs.id
                ],
                'filtre_fixe' => [
                    'logHead' => 'log_details.log_head_id'
                ],
                'filtre_permanent' => [
                    'log_details.is_enable' => 1
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


        if (isset($_GET['logHead'])) {
            $modLogHead = logHead::find($_GET['logHead']);
        } else {
            return redirect(route('home'));
        }

        // Titre
        Core::setTitre("log_details");

        // Création boutons
        // Core::button_add(['id' => "ajouter", 'label' => "Ajouter log_details", 'route' => route('LogDetail_console.create'), 'type' => Core::getConst('BUTTON_TYPE_AJOUT'), 'icon' => '', "class" => ""]);

        // Route pour la grille
        Core::route_add('grille', route('rras3k.LogDetail.listeBt') . '?filtre_fixe[logHead]=' . $modLogHead->id);

        // Nom des routes destroy, create ...
        // Core::routeName_add('destroy', 'LogDetail_console.destroy');
        // Core::routeName_add('edit', 'LogDetail_console.edit');

        // Paras
        Core::setParas($this->getPara());

        // Option de filtre


        // Process
        Core::processForView();

        return view('sebconsoleviews::LogDetail_index', compact('data'));


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
        $model = LogDetail::find($modelId);

        // Titre de la page
        Core::setTitre("log_details: Edition de " . $model->id);

        // Route pour update
        Core::routeName_add('update', 'LogDetail_console.update');

        // Route pour update
        Core::routeName_add('edit', 'LogDetail_console.edit');

        // Core::form_setHiddenValues([
        //     'formulaire_id' => $formulaire->_id
        // ]);

        Core::data_setList('log_heads', LogHead::getList());
        Core::data_setList('roles', Role::getList());

        // Indique qu'on est en mode mise à jour
        Core::form_setIsCreate(false);

        // Passe les datas du modele pour les éditer
        Core::form_setData($model);

        // Process
        Core::processForView();

        return view('LogDetail_console_edit', compact('data'));
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
            'log_head_id' => 'required',
            'texte' => 'required',
            'role_id' => 'required',
        ], $this->PersonaliseErreur());
        $model = LogDetail::find($modelId);
        $model->log_head_id = $request->log_head_id;
        $model->texte = $request->texte;
        $model->role_id = $request->role_id;
        $model->save();
        return redirect(route('LogDetail_console.index'));
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
        Core::setTitre('Création LogDetail');

        // Route pour store
        Core::routeName_add('store', 'LogDetail_console.store');

        // Indique qu'on est en mode création
        Core::form_setIsCreate(true);

        Core::data_setList('log_heads', LogHead::getList());
        Core::data_setList('roles', Role::getList());

        return view('LogDetail_console_edit', compact('data'));
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
            'log_head_id' => 'required',
            'texte' => 'required',
            'role_id' => 'required',
        ], $this->PersonaliseErreur());

        $model = new LogDetail();
        $model->log_head_id = $request->log_head_id;
        $model->texte = $request->texte;
        $model->role_id = $request->role_id;
        $model->save();
        return redirect(route('LogDetail_console.index'));
    }

    private function PersonaliseErreur()
    {
        return [
            'log_head_id.required' => 'Ce champ est obligatoire',
            'texte.required' => 'Ce champ est obligatoire',
            'role_id.required' => 'Ce champ est obligatoire',
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
        $model = LogDetail::find($modelId);
        $model->is_enable = 0;
        $model->save();
        return redirect(route('LogDetail_console.index'));
    }
}
