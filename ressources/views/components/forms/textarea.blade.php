<div class="col-{{ $col }} position-relative" id="entree-{{ $nom }}">
    <label for="input-{{ $nom }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control  @error($nom) is-invalid @enderror " id="input-{{ $nom }}"
        rows="{{ $rows }}" placeholder="{{ $placeholder }}" name="{{ $nom }}">{{ $value }}</textarea>
    @error($nom)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
