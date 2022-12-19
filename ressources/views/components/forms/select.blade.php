@props([
    'col',
    'nom',
    'label',
    'required' => isset($required) && $required == 'false' ? false : true,
    'liste',
    'listeId',
    'value',
    'listeValue'
    ])

<div class="form-floating mb-1">
    <select id="input-{{ $nom }}"
        class="form-select @if ($required) input-required @endif @error($nom) is-invalid @enderror"
        name="{{ $nom }}">
        {{ $trouve = false }}
        @foreach ($liste as $elt)
            @if ($elt[$listeId] == $value)
                {{ $selected = 'selected' }}
                {{ $trouve = true }}
            @else
                {{ $selected = '' }}
            @endif
            <option value="{{ $elt[$listeId] }}" {{ $selected }}>
                {{ $elt[$listeValue] }}
            </option>
        @endforeach
        @if (!$trouve)
            <option selected value="">Choisir...</option>
        @endif
    </select>
    <label for="input-{{ $nom }}" class="form-label label_form">{{ $label }}</label>

    @error($nom)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

{{-- </div> --}}
