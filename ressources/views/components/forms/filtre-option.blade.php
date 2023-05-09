@props([
    'paras' => null,
])

<?php
if ($paras == null) {
    return null;
}
?>
@foreach ($paras as $key => $para)
    {{-- {{dd($para)}} --}}
    <select class="form-control width-auto" name="filtre[{{$para['id']}}]" id="filtre_{{$para['id']}}">
        @if(isset($para['option_do_choice']) && $para['option_do_choice'])
            <option value="">{{$para['option_do_choice']}}</option>
        @endif
        @foreach ($para['datas'] as $key => $value)
            <option value="{{$value['id']}}">{{$value['label']}}</option>
        @endforeach
    </select>
@endforeach
