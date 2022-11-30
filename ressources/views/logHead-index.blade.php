<?php

?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
    <script src="{{ asset('js/bt.js') }}"></script>

@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Groupe Logs</div>
        <div class=" menu_page-SB">
            {{-- <x-menus.page :liste="$menuPage"></x-menus.page> --}}
        </div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="row">
                <div id="toolbar" class="col text-start">
                    <select class="form-control width-auto" name="filtre[log_types]" id="filtre_log_type">
                        <option value="">Tous les types</option>
                        <option value="8" disabled="true">Rubrique</option>
                        @foreach ($data['log_types'] as $key => $elt)
                            <option value="{{ $elt->id }}">{{ $elt->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped"
                    data-page-size="25" data-show-toggle="true" data-show-columns-toggle-all="true" data-show-columns="true"
                    data-buttons="buttons" data-side-pagination="server" data-row-style="rowStyle" data-pagination="true"
                    data-unique-id="id" data-mobile-responsive="false" data-locale="fr-FR" data-toggle="table"
                    data-search="true" data-show-refresh="true" data-url="{{ ROUTE('logHead.listeBt') }}">
                    <thead>
                        <tr>
                            <th data-halign="center" data-field="favori" data-width="40" onClickCell="test"
                                data-sortable="true" data-formatter="favoriFormatter" data-align="center">Favoris</th>
                            <th data-halign="center" data-field="id" data-width="30" data-align="right"
                                data-sortable="true">ID</th>
                            <th data-halign="center" data-field="user_nom" data-width="30" data-align="left"
                                data-sortable="true">User</th>
                            <th data-halign="center" data-field="texte" data-width="200" onClickCell="test"
                                data-sortable="true" data-align="left">
                                Texte</th>
                            <th data-halign="center" data-field="log_type_nom" data-width="300" data-sortable="true">
                                Type</th>
                            <th data-halign="center" data-field="created_at" data-sortable="true" data-width="200"
                                data-formatter="dateFormatter">
                                Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        var url = '{{ route('logDetail.listeBt') }}';
        var logId
        var selectedRow = {}

        window.onload = function() {
            //---------- BT
            // btIsFiltreFixe('table', )
            btAddTable('table')
            btAddFiltreSelect('table', 'filtre_log_type')
        }

        function favoriFormatter(value, row) {
            return '<i class="' + getFavoriHtml(value) + '"></i> '
        }

        function getFavoriHtml(value) {
            return value == 1 ? "bi bi-star-fill" : "bi bi-star"
        }

        function dateFormatter(value, row) {
            var a = moment(value)
            return a.format('DD/MM/YYYY HH:mm:ss') + '  (' + moment().diff(a, 'days') + ')'

        }
        //data-ajax="ajaxRequest" data-ajax="ajaxRequest"
        function queryParams(params) {
            params.id = logId
            return params
        }
        $(function() {
            logShow()
            $('#table').on('click-row.bs.table', function(e, row, $element) {
                console.log("clique ligne log")
                window.location.href = "{{ route('logDetail.index') }}" + "/" + row.id

                // selectedRow = row
                // $('.bt_active').removeClass('bt_active')
                // $($element).addClass('bt_active')
                // logHide()
            })
        })

        function rowStyle(row) {
            if (row.id === selectedRow.id) {
                return {
                    classes: 'bt_active'
                }
            }
            return {}
        }

        // Retour detailLog
        $('#sb-id-log').on('click', function() {
            console.log("shooooowwwww")
            logShow()
        })
        // $('#sb-id-log').on('click', function() {
        //     console.log("hiiiiide")
        //     logHide()
        // })

        function logHide() {
            $('#panel_1').hide()
            $('#panel_2').show()
            $('#sb-id-log').show()

        }

        function logShow() {
            $('#panel_1').show()
            $('#panel_2').hide()
            $('#sb-id-log').hide()
        }



        $('#table').on('click-cell.bs.table', function(event, field, value, row) {
            if (field == 'favori') {
            } else {
            }

        })
    </script>
@endsection
@section('foot-link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/bootstrap-table.min.css"
        integrity="sha512-HIPiLbxNKmx+x+VFnDHICgl1nbRzW3tzBPvoeX0mq9dWP9H1ZGMRPXfYsHhcJS1na58bzUpbbfpQ/n4SIL7Tlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/bootstrap-table.min.js"
        integrity="sha512-9KY1w0S1bRPqvsNIxj3XovwFzZ7bOFG8u0K1LByeMVrzYhLu3v7sFRAlwfhBVFsHRiuMc6shv1lRLCTInwqxNg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/locale/bootstrap-table-fr-FR.min.js"
        integrity="sha512-rdiDwIkdQKzPX7TK92ErRaHRij2Au6iV6R9gDCbSram4Gj3Ot9b1XaEWXhrZbyEJ1Osw22KTP+gv88tMoxifHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/extensions/mobile/bootstrap-table-mobile.min.js"
        integrity="sha512-toeBVwgLo5HT4kMaP5wmR33XATxvuaAqNtzmYNvnU/OsocnTNWuXJw9n7o6H23hH3goD114qic/O6IfNDH7X6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
