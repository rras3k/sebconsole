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
    </div>

    <script></script>
@endsection

@section('foot-link')
{{-- @include('sebconsoleviews::include.load-bootstrap-table') --}}
@endsection
