@props(['indice', 'libelleHeader', 'bgc' => ''])

<div class="accordion-item">

    <h2 class="accordion-header" id="panelsStayOpen-heading{{ $indice }}">
        <button class="accordion-button {{ $bgc }}" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapse{{ $indice }}" aria-expanded="true"
            aria-controls="panelsStayOpen-collapse{{ $indice }}">
            {{ $libelleHeader }}
        </button>
    </h2>
    <div id="panelsStayOpen-collapse{{ $indice }}" class="accordion-collapse collapse show"
        aria-labelledby="panelsStayOpen-heading{{ $indice }}">

        <div class="accordion-body row">
            {{ $slot }}
        </div>
    </div>
</div>
