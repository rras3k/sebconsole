{{-- type = text, date, tel, mail, passwd, date
     col = suffix de la classe bootstrap pour le comportemen d'affichage selon le media sur la colonne
     nom = name de l'entrée du formulaire
     placeholder = placeholder
     label = texte d'information sur la saisie

     exemple :
     <x-forms.input type="text" col="2" :value="$input_formule" readonly="true" nom="" label="Formule actuelle" placeholder="">
    </x-forms.input>
- --}}
@props([
    'col' => 12,
    'type' => 'text',
    'nom',
    'label',
    'value',
    'readonly'=> isset($readonly) && $readonly=="true" ? true : false,
    'required' => isset($required) && $required=="false" ? false : true,
    'placeholder',
])
{{--  --}}
{{-- <div class="col-{{ $col }} position-relative" id="entree-{{ $nom }}"> --}}

    @if ($type == 'radio' || $type == 'checkbox')
        <div class="form-check form-check-inline">
            @if ($label)
                <label class="form-check-label" for="input-{{ $nom }}">
                    {{ $label }}
                </label>
            @endif
            <input class="form-check-input" type="{{ $type }}" name="{{ $nom }}"
                id="input-{{ $nom }}" @if (isset($readonly) && $readonly) disabled @endif
                @if ($value != '' && $value != '0') checked="true" @endif>
        </div>
    @else
        <div class="form-floating mb-1" id="entree-{{ $nom }}"">
            <input type="{{ $type }}" class="form-control @if ($readonly) input-readonly @endif @if ($required) input-required @endif @error($nom) is-invalid @enderror "
                id="input-{{ $nom }}" placeholder=" " name="{{ $nom }}"
                value="{{ $value }}" @if (isset($readonly) && $readonly) readonly @endif>
            @if ($label)
                <label for="input-{{ $nom }}" class="label_form">
                    {{ $label }}
                </label>
            @endif
        </div>
    @endif

    @error($nom)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

{{-- </div> --}}

