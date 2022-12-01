<?php
$menuPage = [['titre' => 'Menu1', 'url' => '#', 'classIcon' => 'fa-solid fa-building'], ['titre' => 'Menu2', 'url' => '#', 'classIcon' => 'fa-solid fa-building']];
?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Utilisateurs</div>
        <div class=" menu_page-SB">
            {{-- <x-menus.page :liste="$menuPage"></x-menus.page> --}}
        </div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="row">
                <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped" data-page-size="25"
                    data-show-toggle="true" data-show-columns-toggle-all="true" data-show-columns="true"
                    data-buttons="buttons" data-side-pagination="server" data-row-style="rowStyle" data-pagination="true"
                    data-unique-id="id" data-mobile-responsive="false" data-locale="fr-FR" data-toggle="table"
                    data-search="true" data-show-refresh="true" data-url="{{ route('user.listeBt') }}">
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

    <script></script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection

