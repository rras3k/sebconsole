<?php
// dd($data);
?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Génération VMC</div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="panel-header">
                Saisie des paramètres
                <x-sebconsoleviews::composants.badge texte="Rapport" type="success" />

            </div>
            <div class="panel-content">
                <div style="text-align: center;">
                    <select id="selectId" name="select_table" style="font-size: 20px;width:300px;">
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
                        <input type="hidden" id="table" name="props[table]"
                            value="{{ $data['infoEntite']['table'] }}" />
                        <div class="class-prop">
                            <div>
                                <div>
                                    App/Models/<input type="text" id="model" name="props[model]"
                                        value="{{ $data['infoEntite']['model'] }}" />
                                </div>
                                <div>
                                    Controller: app/Http/Controllers/<input type="text" id="themeCode"
                                        name="props[themeCode]"
                                        value="{{ $data['infoEntite']['themeCode'] }}" style="width:300px;"/>Controller.php
                                </div>

                                <div>
                                    Label sur une page <input type="text" id="label" name="props[label]"
                                        value="{{ $data['infoEntite']['label'] }}" />
                                </div>
                                <div>

                                    {{ env('APP_URL') }} / <input type="text" id="themeUrl" name="props[themeUrl]"
                                        value="{{ $data['infoEntite']['themeUrl'] }}" style="width:300px;"/>
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
                        <div class="row text-center">
                            <div class="col-1"></div>
                            <div class="col-3 text-bg-success">Grille</div>
                            <div class="col-3 text-bg-danger">Formulaire</div>
                        </div>
                        <div class="row text-center">
                            <div class="col-1">Nom du champ</div>
                            <div class="col-1 text-bg-success">Visible</div>
                            <div class="col-2 text-bg-success">Libellé</div>
                            <div class="col-1 text-bg-danger">Visible</div>
                            <div class="col-2 text-bg-danger">Libellé</div>
                        </div>
                        @foreach ($data['infoChamps'] as $key => $value)
                            <div class="row bg-warning rounded" style="height:40px;">
                                <div class="col-1  align-self-center rounded ps-2" style="background:antiquewhite;">
                                    {{ $value['name'] }}
                                </div>
                                <div class="col-1 text-center align-self-center">
                                    <input type="checkbox" name="champs[{{ $value['name'] }}][grille][visible]"
                                        value="{{ $value['grille']['visible'] }}"
                                        @if ($value['grille']['visible'] == 1) checked @endif>
                                </div>
                                <div class="col-2 align-self-center">
                                    <input class="w-100" type="text" name="champs[{{ $value['name'] }}][grille][label]"
                                        value="{{ $value['name'] }}" />
                                </div>
                                <div class="col-1 text-center align-self-center">
                                    <input type="checkbox" name="champs[{{ $value['name'] }}][form][visible]"
                                        value="{{ $value['form']['visible'] }}"
                                        @if ($value['form']['visible'] == 1) checked @endif>
                                </div>
                                <div class="col-2 align-self-center">
                                    <input class="w-100" type="text" name="champs[{{ $value['name'] }}][form][label]"
                                        value="{{ $value['name'] }}" />
                                </div>
                            </div>
                        @endforeach
                    @endif

                </form>
            </div>
            <div class="panel-footer">
                <div class="col-12">
                    <button form="genereVmc" type="submit" class="btn btn-primary">Générez</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modalƒ
         --}}
    <x-sebconsoleviews::composants.modal titre="Rapport" texte="zz" :boutons="[
        'Fermer' => ['action' => 'ANNULER', 'class' => 'secondary'],
    ]" />
    <style>

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
