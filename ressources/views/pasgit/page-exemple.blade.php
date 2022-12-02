<?php
$input_statut_admin = 1;

// Pour le Select
$data['activites'] = [['id' => 1, 'nom' => 'élément 1'], ['id' => 2, 'nom' => 'élément 2'], ['id' => 3, 'nom' => 'élément 3']];
$data['activite_id'] = 2;

// Input text 1
$input_text1 = 'texte 1';

// Input text 2
$input_text2 = 'texte 2';

// Input textarea
$input_textarea = "La Déclaration des droits de l'homme et du citoyen est née à l'été 1789, du projet de l'Assemblée constituante, formée par la réunion des États Généraux, de rédiger une nouvelle Constitution, et de la faire précéder d'une déclaration de principes.";

?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Page exemple</div>
        <div class=" menu_page-SB">
            {{-- <x-menus.page :liste="$menuPage"></x-menus.page> --}}
        </div>
    </div>

    <div class="zm-content">
        <div class="panel">
            <div class="row">
                <div class="col-12 panel-header">
                    titre panel
                </div>
            </div>

            <div class="row">
                <div class="col-12 panel-rubrique">
                    rubrique 1
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-sebconsoleviews::forms.input type="text" :value="$input_text1" nom="resp_nom"
                        label="Saisir le texte 1" placeholder="">
                        </x-sebconsoleviews>
                </div>
                <div class="col-md-6">
                    <x-sebconsoleviews::forms.input type="text" :value="$input_text2" nom="resp_nom"
                        label="Saisir le texte 2" placeholder="">
                        </x-sebconsoleviews>
                </div>
                <div class="col-md-6">
                    <x-sebconsoleviews::forms.input type="checkbox" col="md-2" :value="$input_statut_admin" nom="statut_admin"
                        label="Admin" placeholder="">
                        </x-sebconsoleviews>
                </div>

                <div class="col-md-6">
                    <x-sebconsoleviews::forms.select :value="$data['activite_id']" :liste="$data['activites']" listeId="id" listeValue="nom"
                        nom="categorie_id" label="Select 1" placeholder="">
                        </x-sebconsoleviews>
                </div>
                {{-- <div class="col-md-6">
                        <x-forms.select :value="$input_massage_jesuis_id" :liste="$data['massage_jesuis']" listeId="id" listeValue="nom"
                            nom="massage_jesuis_id" label="Je suis ..." placeholder=""></x-forms.select>
                    </div>
                    <div class="col-md-12">
                        <x-forms.input type="checkbox" :value="$input_deplace" nom="deplace" label="Se déplace" placeholder="">
                        </x-forms.input>
                    </div> --}}

            </div>
            <div class="row">
                <div class="col-12 panel-rubrique">
                    rubrique 2
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-sebconsoleviews::forms.textarea col="12" rows="5" :value="$input_textarea" nom="description"
                        label="Description" placeholder="Saisir la description détaillées de votre activité">
                        </x-sebconsoleviews>
                </div>
                <div class="col-md-6">
                    <x-sebconsoleviews::forms.input type="text" :value="$input_text1" nom="resp_nom"
                        label="Saisir le texte 1" placeholder="">
                        </x-sebconsoleviews>
                        <x-sebconsoleviews::forms.input type="text" :value="$input_text2" nom="resp_nom"
                            label="Saisir le texte 2" placeholder="">
                            </x-sebconsoleviews>
                            <x-sebconsoleviews::forms.input type="text" :value="$input_text2" nom="resp_nom"
                                label="Saisir le texte 2" placeholder="">
                                </x-sebconsoleviews>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-secondary">Secondary</button>
                    <button type="button" class="btn btn-success">Success</button>
                    <button type="button" class="btn btn-danger">Danger</button>
                    <button type="button" class="btn btn-warning">Warning</button>
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-light">Light</button>
                    <button type="button" class="btn btn-dark">Dark</button>

                    <button type="button" class="btn btn-link">Link</button>
                </div>
            </div>

        </div>
        <br />
        <div class="panel">
            <div class="row">
                <div class="col-12 panel-header">
                    Liste des utilisateurs
                </div>
            </div>

            <div class="row">
                <table id="table" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped"
                    data-page-size="25" data-show-toggle="true" data-show-columns-toggle-all="true" data-show-columns="true"
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
    {{-- Présent pour les tableaux --}}
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
