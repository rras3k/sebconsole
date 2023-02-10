{{--
Exemples:

<x-sebconsoleviews::composants.modal
    titre="Désactivation d'un formullaire"
    texte="Désactiver le formullaire ?"
    :boutons="[
        'Annuler' => ['action' => 'ANNULER'],
        'Oui' => ['action' => 'JS', 'function' => 'desactiverFormuleFormulaire'],
    ]" />

--}}

@props([
    'titre' => '',
    'texte' => '',
    'boutons',
])

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $titre }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $texte }}
            </div>
            <div class="modal-footer">
                @foreach ($boutons as $boutonLabel => $boutonInfo)
                    @php
                        $onclick = '';
                        if (isset($boutonInfo['action'])) {
                            switch ($boutonInfo['action']) {
                                case 'ANNULER':
                                    $onclick = ' data-bs-dismiss=modal ';
                                    break;
                                    case 'JS':
                                    $onclick = ' onclick='.$boutonInfo['function'];
                                    break;
                            }
                        }
                        $_class = 'primary';
                        if (isset($boutonInfo['class'])) {
                            $class = $boutonInfo['class'];
                        }
                    @endphp
                    <button type="button" class="btn btn-{{ $class }}"
                        {{ $onclick }}>{{ $boutonLabel }}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>
