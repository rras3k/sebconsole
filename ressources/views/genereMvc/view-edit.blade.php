<?php
// dd($data);
?>
<{{$data['php']}}
use Rras3k\SebconsoleRoot\facades\ViewData;
ViewData::setEntites($data['rras3k']);
?>

{{ '@' }}extends('sebconsoleviews::layouts.console')

{{ '@' }}section('head-link')
{{ '@' }}endsection

{{ '@' }}section('content')
	<div class="zm-header">
		<div class="zmh-titre">{!! '{' !!}{ ViewData::page_getTitre() }} </div>
        <div class="zmh-menus">
            {!! '<' !!}x-sebconsoleviews::menus.page :liste="ViewData::menuPage_get()"/>
		</div>
	</div>
 <div class="zm-content">

        <div class="panel-group ">

            <div class="panel sb-w-600">
                
                <div class="panel-content">

                        {!! '@' !!}if (ViewData::form_isCreate())
                        <form id="role" method="POST" action="{!! '{' !!}{ route('{{$data['this']->routeName_store}}') }}"
                            enctype="multipart/form-data" name="role">
                        {!! '@' !!}else
                            <form id="role" method="POST"
                                action="{!! '{' !!}{ route('{{$data['this']->routeName_update}}', ViewData::form_getData('id')) }}"
                                enctype="multipart/form-data" name="role">
                                {{-- <x-sebconsoleviews::forms.hidden :liste="ViewData::form_getHiddenValues()" /> --}}
                                {!! '@' !!}method('PUT')
                    {!! '@' !!}endif
                    {!! '@' !!}csrf
                    <div class="row">
						@foreach ($data['this']->champs as $key => $value)
                            @if($value['form']['visible'])

                                    @if($value['link']['enable'])
                                        {!! '<' !!}x-sebconsoleviews::forms.select :value="ViewData::form_getData('{{$key}}')" :liste="ViewData::data_getList('{{$value['link']['table']}}')" listeId="id" listeValue="label" nom="{{$key}}" label="{{$value['link']['label']}}" placeholder=""/>
                                    
                                    @elseif ($value['type'] == 'boolean')
                                                {!! '<' !!}x-sebconsoleviews::forms.checkbox  :value="ViewData::form_getData('{{$key}}')" nom="{{$key}}" label="{{$value['form']['label']}}"
                                                    placeholder="" />

                                    @elseif ($value['type'] == 'text')

                                    @elseif ($value['type'] == 'numeric')
                                        {!! '<' !!}x-sebconsoleviews::forms.input type="text" :value="ViewData::form_getData('{{$key}}')" nom="{{$key}}" label="{{$value['form']['label']}}"
                                            placeholder=""/>

                                    @else
                                        {!! '<' !!}x-sebconsoleviews::forms.input type="text" :value="ViewData::form_getData('{{$key}}')" nom="{{$key}}" label="{{$value['form']['label']}}"
                                            placeholder=""/>
                                    @endif
								

                            @endif

                        @endforeach


                    </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="col-12">
						{!! '@' !!}if (!ViewData::form_isCreate())
                            <a href="{!! '{' !!}{ route('{{$data['this']->routeName_edit}}', ViewData::form_getData('id')) }}"
                                class="btn btn-secondary">Rafraichir</a>
                        {!! '@' !!}endif                        
                        <button form="role" type="submit" class="btn btn-primary">Enregistrer</button>
                        <a role="button" onclick="history.back()" class="btn btn-secondary">Annuler</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
{{ '@' }}endsection