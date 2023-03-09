@extends('layouts.console')


@section('head-link')
@endsection

@section('content')
    <div class="§_main">

        <div class="§_header">
            <div class="§_titre">Pages en créaton</div>
        </div>
        <div class="§_panel_group">

            <div class="§_panel §_w_600">
                <div class="§_content">
                    <div class="row">
                        @foreach ($data['pages'] as $key => $value)
                            <a href="{{ asset('rras3k/pages-dev/page/') . '/' . $value }}">{{ $value }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script></script>
@endsection
@section('foot-link')
    @include('sebconsoleviews::include.load-bootstrap-table')
@endsection
