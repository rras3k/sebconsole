@props(['nom', 'label', 'value'])
<div class="form-check mb-1 m-1" id="entree-{{ $nom }}">
        <input type="hidden" name="{{ $nom }}" value="0" />
        <input id="input-{{ $nom }}" type="checkbox" name="{{ $nom }}" {{ $value==1 ? 'checked': '' }} value="1" /> 
        <label for="input-{{ $nom }}" class="form-check-label">{{ $label }}</label>
    @error($nom)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
