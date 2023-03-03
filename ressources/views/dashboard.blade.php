<?php
// dd($data);

?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')

<div class="§_main">
        <div class="§_header">
            <div class="§_titre">Dashboard système</div>
        </div>

        {{-- MENU --}}
        <div class="§_panel">
            <div class="§_header">
                Menus
            </div>
            <div class="§_content">
                <a role="button" href="{{route('rras3k.del-menus.show')}}">Supprimer les fihciers menu ( /storage/app/private/menus/*.html)</a>


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

    </style>

    <script>

    </script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
