@extends('layouts.console')


@section('head-link')
@endsection

@section('content')
    <div class="§_page_header">
        <div class="§_titre">Utilisateurs</div>
    </div>

    <div class="§_content">
        <div class="§_panel">
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
