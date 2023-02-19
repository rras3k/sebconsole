@props([
    'datas' => '',
])

{{-- <div class="breadcomb"> --}}

    <nav aria-label="breadcrumb" class="ms-1">
        <ol class="breadcrumb">
            @foreach ($datas as $key => $value)
                <li class="breadcrumb-item">
                   
                    {{-- ni url, ni menus --}}
                    @if (!(isset($value['url']) && $value['url']) && !(isset($value['menus']) && $value['menus']))
                                <span class="badge text-bg-primary">{{ $value['nom'] }}</span>
                    @endif

                    {{-- url --}}
                    @if (isset($value['url']) && $value['url'])
                        <a href="{{ $value['url'] }}">{{ $value['nom'] }}</a>
                    @endif

                    {{-- dropdowns --}}
                    @if (isset($value['menus']) && $value['menus'])
                        <div class="dropdown">
                            <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @if (!(isset($value['url']) && $value['url']))
                                <span class="badge text-bg-primary">{{ $value['nom'] }}</span>
                                    
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($value['menus']['liens'] as $key => $valueLien)
                                    <li><a class="dropdown-item"
                                            href="{{ $valueLien['url'] }}">{{ $valueLien['nom'] }}</a>
                                    </li>
                                    {{-- <li><hr class="dropdown-divider"></li> --}}
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>

                {{-- <li class="breadcrumb-item active" aria-current="page">Library</li> --}}
            @endforeach

        </ol>
    </nav>
{{-- </div> --}}


<style>
    .breadcrumb{
        line-height: 35px;
    }
    .dropdown {

        display: contents;
    }
</style>
