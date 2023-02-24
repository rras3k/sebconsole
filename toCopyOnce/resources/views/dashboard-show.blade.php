<?php
use Rras3k\SebconsoleRoot\facades\ViewData;
ViewData::setEntites($data['rras3k']);
?>
@extends('layouts.console')

@section('head-link')
@endsection

@section('content')
    <div class="§_page_header">
        <div class="zmh-nav">
            <x-sebconsoleviews::nav.breadcombre :liste="ViewData::nav_getPage()" />
        </div>
        <div class="§_titre">{{ ViewData::page_getTitre() }}</div>

        <div class="zmh-menus">
            <x-sebconsoleviews::menus.page :liste="ViewData::menuPage_get()"></x-sebconsoleviews::menus.page>
        </div>

    </div>

    </div>

    <div class="§_content">
        <div class="panel2">

        </div>
    </div>

    <script>
    </script>
@endsection

@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
