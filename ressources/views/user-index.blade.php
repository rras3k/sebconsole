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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css"
        integrity="sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
