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
	use Rras3k\Sebconsole\Http\Controllers\SbController;

    class {{ $data['this']->fileNameController }} extends SbController
	{
		/** * * * @return */
		public function __construct()
    	{
			$this->setEntree('main');
    		parent::__construct();
    	}

		/**
		*
		*
		* @return
		*/
    	public function getPara()
    	{
    		return
			[
				'main' => [
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
                        '{{ $data['this']->props['table'] }}.enable' => 1
                    ],
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
		$data = array();
		// Label
		$data['label_titre'] = "{{ $data['this']->props['label'] }}";
		$data['label_bouton_creer'] = "Ajouter {{ $data['this']->props['label'] }}";
		$data['route_bt'] = route('{{ $data['this']->routeName_listeBt }}');
		$data['route_bouton_creer'] = route('{{ $data['this']->routeName_create }}');

		{{-- $this->menuPage_add('formulaire', route('formulaire.create'), 'bi bi-plus-circle'); --}}
		$data['rras3k'] = $this->dataToView();
		return view('{{ $data['this']->callView_index }}', compact('data'));
    }

    public function listeBt()
    {
	    return $this->listeBootstrapTable('main');
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
		$model->enable = 0;
        $model->save();
        return redirect(route('{{$data['this']->routeName_index}}'));
    }
}
