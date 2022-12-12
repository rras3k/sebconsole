<?php
// dd($data['rras3k']['filtreToString']);
$menuPage = [['titre' => 'Menu1', 'url' => '#', 'classIcon' => 'fa-solid fa-building'], ['titre' => 'Menu2', 'url' => '#', 'classIcon' => 'fa-solid fa-building']];
?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Utilisateurs {{ $data['rras3k']['filtreToString'] }}</div>
        <div class=" menu_page-SB">
            {{-- <x-menus.page :liste="$menuPage"></x-menus.page> --}}
        </div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="panel-content">
                <div id="toolbar" class="col text-start">
                    <select class="form-control width-auto" name="filtre[role]" id="filtre_role">
                        <option value="">Tous les rôles</option>
                        @foreach ($data['rras3k']['listForFiltre']['role'] as $key => $role)
                            <option value="{{ $role->id }}">{{ $role->fonction }}</option>
                        @endforeach
                    </select>
                </div>
                <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" data-toolbar="#toolbar"
                    class="table-striped" data-page-size="25" data-show-toggle="true" data-show-columns-toggle-all="true"
                    data-show-columns="true" data-buttons="buttons" data-side-pagination="server" data-row-style="rowStyle"
                    data-pagination="true" data-unique-id="id" data-mobile-responsive="false" data-locale="fr-FR"
                    data-toggle="table" data-search="true" data-show-refresh="true" data-url="{{ $data['route'] }}">
                    <thead>
                        <tr>
                            <th data-halign="center" data-field="id" data-width="10" data-align="right"
                                data-sortable="true">ID</th>
                            <th data-halign="center" data-field="name" data-width="200" data-align="left"
                                data-sortable="true">User</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            //---------- BT
            // btIsFiltreFixe('table', )
            btAddTable('table')
            btAddFiltreSelect('table', 'filtre_role')

        }
    </script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
