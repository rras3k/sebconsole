@props(['liste'])
@if(isset($liste) && $liste)

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ asset('home') }}">Home</a></li>
        @foreach ($liste as $key => $value)
        @if (isset($value['url1']) && $value['url1'])
        <li class="breadcrumb-item">
            @if (isset($value['type']) && $value['type'])
            <span class="badge bg-secondary">{{$value['type']}}</span>
            @endif
            @if (isset($value['url2']) && $value['url2'])
            <a href="{{ $value['url2'] }}"><i class="fa-solid fa-list"></i></a>
            @endif
            <a href="{{ $value['url1'] }}">{{ $value['label'] }}</a>
        </li>
        @else
        <li class="breadcrumb-item active">
            @if (isset($value['type']) && $value['type'])
            <span class="badge bg-secondary">{{$value['type']}}</span>
            @endif
            @if (isset($value['url2']) && $value['url2'])
            <a href="{{ $value['url2'] }}"><i class="fa-solid fa-list"></i></a>
            @endif

            {{ $value['label'] }}
        </li>
        @endif
        @endforeach
    </ol>



</nav>

@endif
