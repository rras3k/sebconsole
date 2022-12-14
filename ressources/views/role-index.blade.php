<?php
// $data['alerts']=[
//     ['texte'=>"coucou","type"=>"danger"],
// ];
?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Roles</div>
        <div class=" menu_page-SB">
            {{-- <x-menus.page :liste="$menuPage"></x-menus.page> --}}
        </div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="panel-header">
                Liste des roles
            </div>
                <div class="panel-content">
                    <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped"
                        data-page-size="25" data-show-toggle="true" data-show-columns-toggle-all="true"
                        data-show-columns="true" data-buttons="buttons" data-side-pagination="server"
                        data-row-style="rowStyle" data-pagination="true" data-unique-id="id" data-mobile-responsive="false"
                        data-locale="fr-FR" data-toggle="table" data-search="true" data-show-refresh="true"
                        data-url="{{ route('role.listeBt') }}">
                        <thead>
                            <tr>
                                <th data-halign="center" data-field="id" data-width="10" data-align="right"
                                    data-sortable="true">ID</th>
                                <th data-halign="center" data-field="name" data-width="200" data-align="left"
                                    data-sortable="true">Role</th>
                                <th data-halign="center" data-field="fonction" data-width="200" data-align="left"
                                    data-sortable="true">Fonction</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            $('#table').on('click-cell.bs.table', function(event, field, value, row) {
                if (field == 'id') {
                    window.location.href = '{{ route('role.edit', ':id') }}'.replace(':id', row.id);
                }
            });
        }
    </script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
