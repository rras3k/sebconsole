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
    'error' => '',
    'label',
    'value',
    'readonly',
    'message',
    'placeholder',
])
@if ($error == '')
    <?php $error = $nom;
    ?>
@endif
<div class="col-{{ $col }} position-relative" id="entree-{{ $nom }}">

    @if ($type == 'radio' || $type == 'checkbox')
        {{-- {{ dd($value) }} --}}
        <div class="form-check form-check-inline">
            @if ($label)
                <label class="form-check-label" for="input-{{ $nom }}">
                    {{ $label }}
                </label>
            @endif
            <input class="form-check-input" type="{{ $type }}" name="{{ $nom }}"
                id="input-{{ $nom }}" @if (isset($readonly) && $readonly) disabled @endif
                @if ($value != '') checked="true" @endif>
        </div>
    @else
            @if ($label)
                <label class="form-check-label" for="input-{{ $nom }}">
                    {{ $label }}
                </label>
            @endif
        <input type="{{ $type }}" class="form-control  @error($error) is-invalid @enderror "
            id="input-{{ $nom }}" placeholder="{{ $placeholder }}" name="{{ $nom }}"
            value="{{ $value }}" @if (isset($readonly) && $readonly) readonly @endif>
    @endif

    {{-- {{ $nom == 'adresse_complete' ? dd($error, $nom) : '' }} --}}
    @error($error)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>
