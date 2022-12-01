    @foreach ($liste as $elt)
        @if (!isset($elt['class']))
            <?php $elt['class'] = ''; ?>
        @endif
        <a href="{{ $elt['url'] }}" role="button"
            class="btn btn-sm btn-outline-secondary me-1 mt-1 {{ $elt['class'] }}"><i
                class="{{ $elt['classIcon'] }}"></i></i>
            {{ $elt['titre'] }}</a>
    @endforeach
