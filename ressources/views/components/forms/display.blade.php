{{-- <div class="col-{{ $col }} position-relative" id="entree-{{ $nom }}">
    <label for="input-{{ $nom }}" class="form-label label_form">{{ $label }}</label>
    <textarea class="form-control  @error($nom) is-invalid @enderror " id="input-{{ $nom }}"
        rows="{{ $rows }}" placeholder="{{ $placeholder }}" name="{{ $nom }}">{{ $value }}</textarea>
    @error($nom)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}

@props([
    'col' => 12,
    'rows' => 10,
    'readonly'=> false,
    'height'=>'100px',
    'nom',
    'label',
    'value',
    'readonly'=> isset($readonly) && $readonly=="true" ? true : false,
    'required' => isset($required) && $required=="false" ? false : true,
    'placeholder'=> "fefdsfds ",
])
<div class="form-floating" id="display-{{ $nom }}"  >
    <input type="text" disabled="true" value="{{ $value }}" class="form-control" />
    <label for="display-{{ $nom }}" class="label_form">
                {{ $label }}
            </label>

</div>
