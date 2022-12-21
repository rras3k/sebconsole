<?php
use Rras3k\SebconsoleRoot\facades\ViewData;
ViewData::setEntites($data['rras3k']);

// dd();
// $data['alerts']=[
//     ['texte'=>"coucou","type"=>"danger"],
// ];

?>
@extends('sebconsoleviews::layouts.app')

@section('head-link')
@endsection

@section('content')
    <div class="zm-header">
        
        <div class="zmh-titre">{{ ViewData::page_getTitre() }}</div>
        <div class="zmh-menus">
            <x-sebconsoleviews::menus.page :liste="$data['menu_page']"></x-sebconsoleviews::menus.page>
        </div>
    </div>

    <div class="zm-content">
        <div class="panel-group ">

            <div class="panel sb-w-600">
                <div class="panel-header">
                    Edition du role : {{ $data['form']['role']['nom'] }}
                </div>

                <div class="panel-content">

                    @if ($data['isCreate'])
                        <form id="role" method="POST" action="{{ route('role.store') }}" enctype="multipart/form-data"
                            name="role">
                        @else
                            <form id="role" method="POST"
                                action="{{ route('role.update', $data['form']['role']['id']) }}"
                                enctype="multipart/form-data" name="role">
                                <input type="hidden" name="role_id" value="{{ $data['form']['role']['id'] }}">
                                @method('PUT')
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <x-sebconsoleviews::forms.input type="text" :value="$data['form']['role']['nom']" nom="nom" label="Nom"
                                placeholder="">
                                </x-sebconsoleviews>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <x-sebconsoleviews::forms.input type="text" :value="$data['form']['role']['fonction']" nom="fonction" label="Fonction"
                                placeholder="">
                                </x-sebconsoleviews>
                        </div>
                    </div>


                    </form>
                </div>
                <div class="panel-footer">
                    <div class="col-12">
                        @if (!$data['isCreate'])
                            <a href="{{ route('role.edit', $data['form']['role']['id']) }}"
                                class="btn btn-secondary">Rafraichir</a>
                        @endif
                        <button form="role" type="submit" class="btn btn-primary">

                            Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" onclick="test(this)" class="spinable btn btn-primary">
            <span class="spinOff spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Primary</button>
    </div>
    <style>
        /* .spinable>.spinner-border {
                display: none;
            } */
    </style>
    <script>
        function test(pthis) {

            alerte("ça commence")
            rras3k_xhr("GET", "{{ route('user.listeBt') }}", "", 'application/json', testCallback)
        }

        function testCallback(data) {
            alerte('testCallback', 'danger')
            alerte(JSON.stringify(data))
        }
    </script>
@endsection
{{-- @section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection --}}
