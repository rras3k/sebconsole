<?php
// dd($data);
?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')
    <div class="§_page_header">
        <div class="§_titre">Génération VMC: Résultat</div>
    </div>

    <div class="§_content">
        <div class="panel">
            <div class="panel-header">
                Saisie des paramètres

            </div>
            <div class="panel-content">
                <div class="panel-rubrique">
                    A insérer dans le tableau du menu du fichier config
                </div>
                <div>
                    {{$data['toConfig']}}
                </div
            </div>
            <div class="panel-footer">
                <div class="col-12">
                    <a href="{{ route('genereMvc.show') }}" role="button" class="btn btn-primary">Regénérez un autre
                        modèle</a>
                </div>
            </div>
        </div>
    </div>

    <style>

    </style>

    <script></script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
