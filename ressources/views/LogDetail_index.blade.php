<?php
use Rras3k\SebconsoleRoot\facades\Core;
Core::setEntite();
?>

@extends('layouts.console')

@section('head-link')
@endsection

@section('content')
    <div class="§_main">

        <div class="§_header">
            <div class="§_titre">{{ Core::getTitre() }}</div>
        </div>

        <div class="§_nav">

            {{-- <a class="btn btn-primary" href="{{  Core::button_getRoute('ajouter')  }}" role="button">{{ Core::button_getLabel('ajouter') }}</a> --}}
        </div>

        <div class="§_panel">
            <div class="§_content">
                <div id="toolbar" class="col text-start">

                </div>

                <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped"
                    data-page-size="25" data-show-toggle="true" data-show-columns-toggle-all="true" data-show-columns="true"
                    data-buttons="buttons" data-side-pagination="server" data-row-style="rowStyle" data-pagination="true"
                    data-unique-id="id" data-mobile-responsive="false" data-locale="fr-FR" data-toggle="table"
                    data-search="true" data-show-refresh="true" data-url="{{ Core::getRoute('grille') }}">
                    <thead>
                        <tr>

                            <th data-halign="center" data-field="id" data-width="10" data-align="right"
                                data-sortable="true">id</th>
                            <th data-halign="center" data-field="log_head_id_str" data-width="10" data-align="left"
                                data-sortable="true">log_heads</th>
                            <th data-halign="center" data-field="texte" data-width="10" data-align="left"
                                data-sortable="true">texte</th>
                            <th data-halign="center" data-field="role_id_str" data-width="10" data-align="left"
                                data-sortable="true">Role</th>
                            {{-- <th data-halign="center" data-field="action" data-width="50" data-align="center"
                                data-sortable="false" data-formatter="actionFormatter">Action</th> --}}

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <form id="post_del" method="POST" name="post_del">
        @method('DELETE')
        @csrf
    </form>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression LogDetail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    zz
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss=modal>Annuler</button>
                    <button type="button" class="btn btn-primary" onclick=del_enreg()>Oui</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            btAddTable('table')
            // btAddFiltreSelect('table', 'auteurs')

        }


        function getModelStr(row) {
            return row['model_str']
        }



        function is_favori_Formatter(value, row) {
            if (value == 1) {
                return '<i class="fa-solid fa-star"></i>'
            } else {
                return '<i class="fa-regular fa-star"></i>'
            }
            return
        }
        // Formatter
    </script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
