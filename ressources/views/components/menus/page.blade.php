    {{--
    liste[]['class']
    liste[]['url']
    liste[]['classIcon']
    liste[]['titre']
    --}}
    @if ($liste != null)

        @foreach ($liste as $elt)
            @if (!isset($elt['class']))
                <?php $elt['class'] = ''; ?>
            @endif
            <a href="{{ $elt['url'] }}" role="button" @if(isset($elt['onclick'])) onclick="{{$elt['onclick']}}"
                
            @endif
                class="btn btn-sm btn-outline-secondary me-1 mt-1 {{ $elt['class'] }}"><i
                    class="{{ $elt['classIcon'] }}"></i>
                {{ $elt['titre'] }}</a>
        @endforeach
    @endif
