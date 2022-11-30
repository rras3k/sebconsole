<?php
// dd($data);
// dd(Auth()->user());
?>

@extends('sebconsoleviews::layouts.app')

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Console</div>
        <div class="zmh-menus">
            {{-- <x-menus.page :liste="$data['menu_page']"></x-menus.page> --}}
        </div>
    </div>


    <div class="zm-content d-flex justify-content-evenly">
        <div class="panel w-600 ">

        </div>
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Statistiques
                </div>
            </div>
        </div>
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Messages
                </div>
            </div>
        </div>
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Favoris
                </div>
            </div>
        </div>
    </div>
@endsection
