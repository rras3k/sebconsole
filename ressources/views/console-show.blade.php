<?php
// dd($data);
// dd(Auth()->user());
?>

@extends('sebconsoleviews::layouts.console')

@section('content')
    <div class="zm-header">
        <div class="zmh-titre">Console</div>
        <div class="zmh-menus">
            {{-- <x-menus.page :liste="$data['menu_page']"></x-menus.page> --}}
        </div>
    </div>


    <div class="zm-content d-flex justify-content-evenly">
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Panel 1 
                </div>
            </div>
        </div>
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Panel 2
                </div>
            </div>
        </div>
        <div class="panel w-600 d-inline-block">
            <div class="row">
                <div class="col-12 panel-header">
                    Panel 3
                </div>
            </div>
        </div>
    </div>
@endsection
