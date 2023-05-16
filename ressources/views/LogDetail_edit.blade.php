<?php
use Rras3k\SebconsoleRoot\facades\Core;
Core::setEntite();

// dd($data);
// dd(Core::getEntites());
// dd($errors);

?>

    @extends('layouts.console')

    @section('head-link')
    @endsection

    @section('content')
    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">{{ Core::getTitre() }}</div>
        </div>
        <div class="§_panel_group">
            <div class="§_panel §_w_600">
                <div class="§_content">

                    @if (Core::form_isCreate())
                        <form id="role" method="POST"
                        action="{{ route(Core::getRouteName('store')) }}"
                        enctype="multipart/form-data" name="role">
                    @else
                        <form id="role" method="POST"
                            action="{{ route(Core::getRouteName('update'),Core::form_getData('id')) }}"
                            enctype="multipart/form-data" name="role">
                            @method('PUT')
                    @endif
                            <x-sebconsoleviews::forms.hidden :liste="Core::form_getHiddenValues()" />
                            @csrf
                            <div class="row">
                                                                                                                                        
                                                                                    <x-sebconsoleviews::forms.select
                                            :value="Core::form_getData('log_head_id')"
                                            :liste="Core::data_getList('log_heads')"
                                            listeId="id" listeValue="label" nom="log_head_id"
                                            label="log_heads" placeholder=""/>

                                                                                                                                                
                                        
                                                                                                                                                                                                                                                                                                                                                            
                                                                                    <x-sebconsoleviews::forms.select
                                            :value="Core::form_getData('role_id')"
                                            :liste="Core::data_getList('roles')"
                                            listeId="id" listeValue="label" nom="role_id"
                                            label="Role" placeholder=""/>

                                                                                                                                        </div>
                        </form>
                </div>
                <div class="§_footer">
                    <div class="col-12">
                        @if (!Core::form_isCreate())
                        <a href="{{ route(Core::getRouteName('edit'),Core::form_getData('id')) }}"
                            class="btn btn-secondary">Rafraichir</a>
                        @endif
                        <button form="role" type="submit" class="btn btn-primary">Enregistrer</button>
                        <a role="button" onclick="history.back()" class="btn btn-secondary">Annuler</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script></script>
    @endsection
