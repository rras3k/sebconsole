<?php
// dd($data);
function getFunctionName($champName)
{
    if ($champName == 'is_favori') {
        return 'favori';
    }
    return $champName;
}
?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')
    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">Génération système</div>
        </div>

        {{-- génération menu --}}


        <form id="genereMenu" method="POST" action="{{ route('genere.run') }}" enctype="multipart/form-data" name="genereMenu">
            @csrf
            <input type="hidden" id="generation" name="generation" value="menu" />

            <div class="§_panel §_w_600">
                <div class="§_header">
                    Menus
                </div>
                <div class="§-content">
                </div>
                <div class="§_footer">
                    <div class="col-12">
                        <button form="genereMenu" type="submit" class="btn btn-primary">Générez les menus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modalƒ --}}
    <x-sebconsoleviews::composants.modal titre="Rapport" texte="zz" :boutons="['Fermer' => ['action' => 'ANNULER', 'class' => 'secondary']]" />

    <style></style>
    <script></script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
