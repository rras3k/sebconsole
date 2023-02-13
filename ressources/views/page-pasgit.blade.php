@extends('sebconsoleviews::layouts.console')


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
				@foreach($data['pages'] as $key => $value)
				<a href="{{asset('console/pages-pasgit/page/').'/'.$value}}">{{$value}}</a>
					
				@endforeach

            </div>
        </div>
    </div>

    <script></script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
