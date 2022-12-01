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
				Panel
            </div>
        </div>
    </div>

    <script></script>
@endsection

@section('foot-link') 
    {{-- Présent pour les tableaux --}}
    @include('sebconsoleviews::include.load-bootstrap-table')  
@endsection

