{{-- type = text, date, tel, mail, passwd, date
     col = suffix de la classe bootstrap pour le comportemen d'affichage selon le media sur la colonne
     nom = name de l'entrée du formulaire
     placeholder = placeholder
     label = texte d'information sur la saisie

     exemple :
     <x-forms.input type="text" col="2" :value="$input_formule" readonly="true" nom="" label="Formule actuelle" placeholder="">
    </x-forms.input>
- --}}
@php
    const ETAT_NO_EDIT = 0;
    const ETAT_EDIT = 1;
@endphp
@props([
    'col' => 12,
    'type' => 'text',
    'nom',
    'label',
    'forZoneValidation',
    'etat' => isset($etat) && $etat ? $etat : ETAT_EDIT,
    'value' => isset($value) && $value ? $value : '',
    'readonly' => isset($readonly) && $readonly == 'true' ? true : false,
    'required' => isset($required) && $required == 'false' ? false : true,
    'placeholder',
])

{{--  --}}
{{-- <div class="col-{{ $col }} position-relative" id="entree-{{ $nom }}"> --}}
@if ($type == 'radio' || $type == 'checkbox')
    <div class="form-check form-check-inline">
        @if ($label)
            <label class="form-check-label label_form" for="input-{{ $nom }}">
                {{ $label }}
            </label>
        @endif
        <input class="form-check-input" type="{{ $type }}" name="{{ $nom }}" id="input-{{ $nom }}"
            @if (isset($readonly) && $readonly) disabled @endif @if ($value != '' && $value != '0') checked="true" @endif>
        @error($nom)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@else
    <div class="form-floating mb-1" id="entree-{{ $nom }}">
        <input @if ($etat == ETAT_NO_EDIT) disabled="true" @endif type="{{ $type }}"
            @if ($forZoneValidation) for_zone_validation="{{ $forZoneValidation }}" @endif
            class="form-control @if ($readonly) input-readonly @endif @if ($required) input-required @endif @error($nom) is-invalid @enderror "
            id="input-{{ $nom }}" placeholder=" " name="{{ $nom }}" value="{{ $value }}"
            @if ($readonly) readonly @endif value_old="">
        {{-- value="{{ $value }}" @if (isset($readonly) && $readonly) readonly @endif> --}}
        @if ($label)
            <label for="input-{{ $nom }}" class="label_form">
                {{ $label }}
            </label>
        @endif
        <i onclick="inputToggle(this)" for_zone_validation="{{ $forZoneValidation }}" for_input="input-{{ $nom }}" class="i-pointer edit-icon fa fa-pen fa-lg fa-fw"
            aria-hidden="true"></i>

        @error($nom)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endif
<style>
    .form-control {
        padding-left: 30px !important;
    }

    .edit-icon {
        position: absolute;
        top: 27px;
        padding: 9px 8px;
        padding-left: 0px;
        color: blue;
        display: block;
        right: 0px;
        float: right;
    }
</style>
<script>

</script>


{{-- </div> --}}
