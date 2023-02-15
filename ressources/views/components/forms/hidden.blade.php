@props(['liste'])

@if ($liste) 
    @foreach ($liste as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
    @endforeach
@endif
