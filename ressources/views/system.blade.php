<?php
// dd($data);
?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')
    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">Rrask3 système</div>
        </div>

        <div class="§_panel_group">
            {{-- MENU --}}
            <div id="menus" class="§_panel §_w_800">
                <div class="§_header">
                    Divers
                </div>
                <div class="§_content">
                    <div class="wrap">
                        <label for="delMenus">Supprimer les fichiers menu (/storage/app/private/menus/*.html)</label>
                        <a role="button" id="delMenus" class="btn btn-primary btn-sm"
                            href="{{ route('rras3k.del-menus') }}">Supprimer</a>
                    </div>
                    <div class="§_br"></div>
                    <div class="wrap">
                        <label for="delMenus">Raz 1 base de données (formulaire, formule, formuleFormulaire)</label>
                        <a role="button" id="delMenus" class="btn btn-primary btn-sm"
                            href="{{ route('rras3k.del-menus') }}">Raz</a>
                    </div>

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
        #menus .wrap {
            display: flex;
            justify-content: space-between;
        }

        #models {
            font-size: 17px;
            width: 300px;
            height: 250px;
        }
    </style>

    <script></script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
