<?php
// dd($data);
function getFunctionName($champName)
{
    return $champName;
}
?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')

    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">Génération VMC</div>
        </div>
        <div class="§_panel">
            <div class="§_header">
                Saisie des paramètres
                <x-sebconsoleviews::composants.badge texte="Rapport" type="success" />

            </div>
            <div class="§_content">

                {{-- Choix de la table --}}
                <div style="text-align: center;">
                    <select id="selectId" name="select_table" style="font-size: 20px;width:300px;">
                        <option value="">Choisir une table</option>

                        @foreach ($data['tables'] as $key => $value)
                            @php $selected = ""; @endphp
                            @if ($value == $data['table_select'])
                                @php $selected = " selected "; @endphp
                            @endif
                            <option value="{{ $value }}" {{ $selected }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <form id="genereVmc" method="POST" action="{{ route('genereMvc.run') }}" enctype="multipart/form-data"
                    name="genereVmc">
                    @csrf
                    @if (isset($data['infoEntite']['table']))
                        <div>
                            <input type="checkbox" id="genereOnlyModel" name="genereOnlyModel" value="1">
                            <label for="genereOnlyModel">Ne générer que le modèle</label>
                        </div>

                        <input type="hidden" id="table" name="props[table]"
                            value="{{ $data['infoEntite']['table'] }}" />

                        {{-- Saisi des propriétés --}}
                        <div class="class-prop">
                            <div>
                                <div>
                                    App/Models/<input type="text" id="model" name="props[model]"
                                        value="{{ $data['infoEntite']['model'] }}" />
                                </div>
                                <div>
                                    Controller: app/Http/Controllers/<input type="text" id="themeCode"
                                        name="props[themeCode]" value="{{ $data['infoEntite']['themeCode'] }}"
                                        style="width:300px;" />_Controller.php
                                </div>

                                <div>
                                    Label sur une page <input type="text" id="label" name="props[label]"
                                        value="{{ $data['infoEntite']['label'] }}" />
                                </div>
                                <div>

                                    {{ env('APP_URL') }} / <input type="text" id="themeUrl" name="props[themeUrl]"
                                        value="{{ $data['infoEntite']['themeUrl'] }}" style="width:300px;" />
                                    / ...
                                </div>
                                <div>
                                    <input type="checkbox" id="genereRoute" name="genereRoute" value="1">
                                    <label for="genereRoute">Ecrire les routes dans web.php</label>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" onclick="check()">Check</button>
                            </div>
                        </div>

                        {{-- Saisi des informations sur chaque champ --}}
                        <div class="row g-0 text-center">
                            <div class="col-2"></div>
                            <div class="col-3 text-bg-success">Grille</div>
                            <div class="col-3 text-bg-danger">Formulaire</div>
                            <div class="col-4"></div>

                            <div class="col-1">Nom du champ</div>
                            <div class="col-1">Str</div>
                            <div class="col-1 text-bg-success">Visible</div>
                            <div class="col-2 text-bg-success">Libellé</div>
                            <div class="col-1 text-bg-danger">Visible</div>
                            <div class="col-2 text-bg-danger">Libellé</div>
                            <div class="col-4"></div>
                        </div>
                        @foreach ($data['infoChamps'] as $key => $value)
                            <div class="row g-0 bg-warning rounded" style="height:40px;">
                                <div class="col-1  ligne-champ align-self-center rounded ps-2"
                                    style="background:antiquewhite;">
                                    {{ $value['name'] }}
                                </div>
                                <div class="col-1  ligne-champ text-center align-self-center">
                                    <input type="radio" value="{{ $key }}" name="props[champStr]" />
                                </div>
                                <div class="col-1 ligne-champ text-center align-self-center">
                                    <input type="hidden" name="champs[{{ $value['name'] }}][grille][visible]"
                                        value="0" />

                                    <input type="checkbox" name="champs[{{ $value['name'] }}][grille][visible]"
                                        value="1" @if ($value['grille']['visible'] == 1) checked @endif>
                                </div>
                                <div class="col-2 ligne-champ align-self-center">
                                    <input class="w-100" type="text" name="champs[{{ $value['name'] }}][grille][label]"
                                        value="{{ getFunctionName($value['name']) }}" />
                                </div>
                                <div class="col-1 ligne-champ text-center align-self-center">
                                    <input type="hidden" name="champs[{{ $value['name'] }}][form][visible]"
                                        value="0" />

                                    <input type="checkbox" name="champs[{{ $value['name'] }}][form][visible]"
                                        value="{{ $value['form']['visible'] }}"
                                        @if ($value['form']['visible'] == 1) checked @endif>
                                </div>
                                <div class="col-2 ligne-champ align-self-center">
                                    <input class="w-100" type="text" name="champs[{{ $value['name'] }}][form][label]"
                                        value="{{ getFunctionName($value['name']) }}" />
                                </div>
                                <div class="col-4 ligne-champ "></div>
                            </div>
                        @endforeach
                        {{-- </div> --}}
                    @endif

                </form>
            </div>
            <div class="§_footer">
                @if (isset($data['infoEntite']['table']))
                    <div class="col-12">
                        <button form="genereVmc" type="submit" class="btn btn-primary">Générez</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Modalƒ
         --}}
    <x-sebconsoleviews::composants.modal titre="Rapport" texte="zz" :boutons="[
        'Fermer' => ['action' => 'ANNULER', 'class' => 'secondary'],
    ]" />

    <style>
        .ligne-champ {
            /* background:rgb(245, 229, 10);
                    height:40px; */
        }
    </style>

    <script>
        window.onload = function() {
            elt = document.querySelector('#selectId')
            elt.addEventListener("change", function() {
                window.location = "{{ route('genereMvc.show') }}?table=" + this.value
            })
        }

        function check() {
            data = getProps()
            rras3k_xhr('GET', "{{ route('genereMvc.check') }}", data, 'application/json', fctCallback,
                "{{ csrf_token() }}")
        }

        function getProps() {
            ret = {
                'model': document.querySelector('#model').value,
                'table': document.querySelector('#table').value,
                'label': document.querySelector('#label').value,
                'themeCode': document.querySelector('#themeCode').value,
                'themeUrl': document.querySelector('#themeUrl').value
            }
            return ret
        }

        function fctCallback(data) {
            console.log(data)
            // alerte(data["message"],'success',2000)
            modalShow(data['titre'], data['messages'])
        }

        function modalShow(titre, texte) {
            elt = document.querySelector('#myModal .modal-body')
            elt.innerHTML = texte
            elt = document.querySelector('#exampleModalLabel')
            elt.innerHTML = titre
            myModal = new bootstrap.Modal(document.getElementById('myModal'), {})
            myModal.show()
        }
    </script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
