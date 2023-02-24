<?php
// dd($data);
?>
<{{$data['php']}}
	namespace App\Http\Controllers;
	use App\Models\{{ $data['this']->props['model'] }};
	@foreach ($data['this']->champs as $key => $value)
		    @if($value['link']['enable'])
				use App\Models\{{ $value['link']['model'] }};
			@endif
        @endforeach
	use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
    use Rras3k\SebconsoleRoot\facades\Core;


    class {{ $data['this']->fileNameController }} extends Controller
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

					'table_principale' => '{{ $data['this']->props['table'] }}',
					'jointure' => [
				@foreach ($data['this']->champs as $key => $value)
				@if($value['link']['enable'])
					['type' => 'left join', 'table' => '{{$value['link']['table']}}', 'on' => '{{$value['link']['table']}}.id', 'cible' => '{{ $data['this']->props['table'] }}.{{ $key }}'],
				@endif
				@endforeach

					],
					'champs' => [
			@foreach ($data['this']->champs as $key => $value)
				'{{ $value['name'] }}'=> ['table' => '{{ $data['this']->props['table'] }}', 'champ_table' => '{{ $value['name'] }}'],
				@if($value['link']['enable'])
					'{{ $value['name'] }}_str'=> ['table' => '{{$value['link']['table']}}', 'champ_table' => '{{ $value['link']['str'] }}'],
				@endif
				@endforeach
				'model_str'=> ['table' => '{{ $data['this']->props['table'] }}', 'champ_table' => '{{$data['this']->props['champStr']}}'],
					],
					// 'filtre' => [],
					'filtre_fixe' => [
					],
					'filtre_permanent' => [
                        '{{ $data['this']->props['table'] }}.is_enable' => 1
                    ],
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
        $data = array();

        // initialisation avec le nom de l'entité par défaut: "main"
        Core::init();

        // Titre
        Core::setTitre("{{ $data['this']->props['label'] }}");

        // Création boutons
        Core::button_add(['id' => "Ajouter {{ $data['this']->props['label'] }}", 'label' => "Ajouter {{ $data['this']->props['label'] }}", 'route' => route('{{ $data['this']->routeName_create }}'), 'type' => Core::BUTTON_TYPE_AJOUT,'icon' => '', "class" => ""]);

        // Route pour la grille
        Core::setRoute('grille', route('{{ $data['this']->routeName_listeBt }}'));

        // Nom des routes destroy, create ...
        Core::setRouteName('destroy', '{{$data["this"]->routeName_destroy}}');
        Core::setRouteName('edit', '{{$data["this"]->routeName_edit}}');

        // Paras
        Core::setParas($this->getPara());

        // Process
        Core::processForView();

        return view('{{ $data['this']->callView_index }}', compact('data'));

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
    public function edit( $modelId)
    {
        //
        $data = array();
		$model= {{ $data['this']->props['model'] }}::find($modelId);

        {{-- $this->page_setTitre('{{$data['this']->props['label']}}: Edition de '.$model->{{$data['this']->props['champStr']}}); --}}

		$data['label_titre'] = "{{$data['this']->props['label']}}: Edition de ".$model->{{$data['this']->props['champStr']}};



        // $this->form_setHiddenValues([
        //     'formulaire_id' => $formulaire->_id
        // ]);

		@foreach ($data['this']->champs as $key => $value)
		    @if($value['link']['enable'])
	       		$this->data_setList('{{ $value['link']['table'] }}', {{ $value['link']['model'] }}::getList());
			@endif
        @endforeach

        $this->form_setIsCreate(false);
        $this->form_setData($model);
        $data['rras3k'] = $this->dataToView();

        return view('{{$data['this']->callView_edit}}', compact('data'));
    }

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $modelId)
    {
        // dd($request);
        $validated = $request->validate([
			@foreach ($data['this']->champs as $key => $value)
			@php
			 if($value['form']['visible']){
			@endphp
            '{{$key}}' => 'required',
			@php
				}
			@endphp
            @endforeach
        ], $this->PersonaliseErreur());
		$model = {{$data['this']->props['model']}}::find($modelId);
		@foreach ($data['this']->champs as $key => $value)
		@php
			 if($value['form']['visible']){
			@endphp
		$model->{{$key}} = $request->{{$key}};
		 @php
				}
			@endphp
        @endforeach
        $model->save();
        return redirect(route('{{$data['this']->routeName_index}}'));
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
        // dd($request);
        $validated = $request->validate([
			@foreach ($data['this']->champs as $key => $value)
			@php
			 if($value['form']['visible']){
			@endphp
            '{{$key}}' => 'required',
			@php
				}
			@endphp
            @endforeach
        ], $this->PersonaliseErreur());

		$model = new {{$data['this']->props['model']}}();
		@foreach ($data['this']->champs as $key => $value)
		@php
			 if($value['form']['visible']){
			@endphp
		$model->{{$key}} = $request->{{$key}};
		 @php
				}
			@endphp
        @endforeach
        $model->save();
        return redirect(route('{{$data['this']->routeName_index}}'));
    }

	private function PersonaliseErreur()
    {
        return [
			@foreach ($data['this']->champs as $key => $value)
		@php
			 if($value['form']['visible']){
			@endphp
		'{{$key}}.required' => 'Ce champ est obligatoire',
		 @php
				}
			@endphp
        @endforeach
        ];
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
        $data = array();
		$data['label_titre'] = 'Création {{ $data['this']->props['model'] }}';
        $this->form_setIsCreate(true);
		@foreach ($data['this']->champs as $key => $value)
		    @if($value['link']['enable'])
	       		$this->data_setList('{{ $value['link']['table'] }}', {{ $value['link']['model'] }}::getList());
			@endif
        @endforeach

        $data['rras3k'] = $this->dataToView();
        return view('{{$data['this']->callView_edit}}', compact('data'));
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
		$model = {{$data['this']->props['model']}}::find($modelId);
		$model->is_enable = 0;
        $model->save();
        return redirect(route('{{$data['this']->routeName_index}}'));
    }
}
