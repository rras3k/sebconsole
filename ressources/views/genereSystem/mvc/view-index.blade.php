<?php
// use Rras3k\SebconsoleRoot\facades\ViewData;
// ViewData::setEntites($data['rras3k']);
?>
<{{$data['php']}}
use Rras3k\SebconsoleRoot\facades\Core;
Core::setEntite();
?>

{{ '@' }}extends('layouts.console')

{{ '@' }}section('head-link')
{{ '@' }}endsection

{{ '@' }}section('content')

<div class="§_main">

    <div class="§_header">
        <div class="§_titre">{!! '{' !!}{ Core::getTitre() }}</div>
    </div>

    <div class="§_nav">
        {{-- {!! '<' !!}x-sebconsoleviews::composants.breadcrumb :datas="ViewData::breadcrumb_get()" /> --}}
        <a class="btn btn-primary" href="{!! '{' !!}{  Core::button_getRoute('ajouter')  }}" role="button">{!! '{' !!}{ Core::button_getLabel('ajouter') }}</a>
    </div>

    <div class="§_panel">
        <div class="§_content">
            <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped" data-page-size="25"
                data-show-toggle="true" data-show-columns-toggle-all="true" data-show-columns="true"
                data-buttons="buttons" data-side-pagination="server" data-row-style="rowStyle" data-pagination="true"
                data-unique-id="id" data-mobile-responsive="false" data-locale="fr-FR" data-toggle="table"
                data-search="true" data-show-refresh="true" data-url="{!! '{' !!}{route(Core::getRouteName('grille'))}}">
                <thead>
                    <tr>
                        {{-- <th data-halign="center" data-field="is_favori" data-width="10"
                                data-align="center" data-sortable="true" data-formatter="is_favori_Formatter">Favori</th> --}}
                        @foreach ($data['this']->champs as $key => $value)
                            @php
                            if ($key == 'is_favori') continue;
                                if ($value['grille']['visible']){
                                    $isFormatter =false;
                                    $dataAlign= "left";
                                    $formatter="";
                                    if(!$value['link']['enable']){
                                        switch($value['type']){
                                            case 'boolean':
                                                $isFormatter =true;
                                                $dataAlign= "center";
                                                break;
                                            case 'numeric':
                                                $dataAlign= "right";
                                                break;
                                        }
                                        if ($isFormatter){
                                            $formatter =' data-formatter="'.$value['name'].'_Formatter" ';
                                        }
                                    }
                                }
                            @endphp
                            @if($value['grille']['visible'])
                            	@if($value['link']['enable'])
                                <th data-halign="center" data-field="{{ $value['name'] }}_str" data-width="10"
                                data-align="{{$dataAlign}}" data-sortable="true" {!! $formatter !!}>{{ $value['link']['label'] }}</th>
                                @else
                                <th data-halign="center" data-field="{{ $value['name'] }}" data-width="10"
                                data-align="{{$dataAlign}}" data-sortable="true" {!! $formatter !!}>{{ $value['grille']['label'] }}</th>
                                @endif
                            @endif
                        @endforeach
                            <th data-halign="center" data-field="action" data-width="50" data-align="center"
                                data-sortable="false" data-formatter="actionFormatter">Action</th>

                    </tr>
                </thead>
            </table>
        </div>
        </div>
</div>

{{-- FORM pour la suppression d'un élément --}}
<form id="post_del" method="POST"  name="post_del">
    {!! '@' !!}method('DELETE')
    {!! '@' !!}csrf
</form>

<x-sebconsoleviews::composants.modal titre="Suppression {{$data['this']->props['model']}}" texte="zz" :boutons="[
        'Annuler' => ['action' => 'ANNULER', 'class' => 'secondary'],
        'Oui' => ['action' => 'JS', 'function' => 'del_enreg()', 'class' => 'primary'],
 ]" />

<script>


    // --- modal suppression
    function del_enreg() {
        if (modal_function_values) {
             const myUrl = '{{$data['aco']}}{ route('{{$data['this']->routeName_destroy}}', ':id') }}'.replace(':id', modal_function_values)
             console.log(myUrl)
            elt = document.querySelector('#post_del')
            elt.setAttribute("action", myUrl)
            elt.submit()

            // rras3k_xhr('DELETE', myUrl, [], 'application/json', fctCallback, "{{$data['aco']}}{ csrf_token() }}")
            // myModal.hide()


        }
    }
    function del_demande(formuleFormulaireId, texte) {
            elt = document.querySelector('#myModal .modal-body')
            elt.innerHTML = 'Supprimer  ' + texte + ' ?'
            formulaireDesactiveStr = texte

            modal_function_values = formuleFormulaireId
            myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
            myModal.show()
    }
    function fctCallback() {
        console.log("avant reload")
        location.reload()
        console.log("après reload")
    }

    function getModelStr(row) {
                return row['model_str']
    }

    function actionFormatter(value, row) {

            return '<div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
                'Actions' +
                '</button>' +
                '<ul class="dropdown-menu">' +
                '<li><a class="dropdown-item" href="'+'{{$data['aco']}}{ route('{{$data["this"]->routeName_edit}}',':id') }}'.replace(':id', row.id)+'"><i class="bi bi-pencil"></i> Modifier</a></li>' +
                '<li><a class="dropdown-item" href="#" onclick="del_demande(' + row.id +
                ',\'' + getModelStr(row) + '\')"><i class="bi bi-x-circle"></i> Supprimer</a></li>' +
                '</ul>' +
                '</div>'
        }

    function is_favori_Formatter(value, row){
        if(value == 1){
            return '<i class="fa-solid fa-star"></i>'
        }
        else{
            return '<i class="fa-regular fa-star"></i>'
        }
        return
    }
    // Formatter
    @foreach ($data['this']->champs as $key => $value)
        @if ($key !='is_favori' && $value['grille']['visible'])
            @php
                switch($value['type']){
                    case 'boolean': // boolean
                    @endphp
                        function {{$value['name']}}_Formatter(value, row) {
                            if(value) return "Oui"
                            else return "Faux"
                        }
                    @php
                        break;
                }
            @endphp
        @endif
    @endforeach


</script>
{{ '@' }}endsection
{{ '@' }}section('foot-link')
{{ '@' }}include('sebconsoleviews::include.load-bootstrap-table')
{{ '@' }}endsection
