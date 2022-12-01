{{-- cal
-------------------------------------------------------------------
|                                                                 |
|                          cal-1                                  |
|                                                                 |
|------------------------------------------------------------------
|   cal-2 |                cal-3                                  |
|         |                                                       |
|------------------------------------------------------------------
|   cal-4 |                cla-5                                  |
|         |                                                       |
|         |                                                       |
------------------------------------------------------------------


Paramètres passés au template :
-----------------------------

$id                 : Identifiant du div du calendrier

$events[]
    ["id"]          : identifiant de l'événement
    ["titre"]       : Titre de l'événement
    ["dateDeb"]     : Date de début de l'événement // ex: "2022-07-26 10:00:00"
    ["dateDeb"]     : Date de fin de l'événement  // ex: "2022-07-26 12:00:00"

$paras
    ["periode"]     :   "jour" : affichage du planning pour un jour, + affichage events
                        "semaine" : affichage du planning du lundi au dimanche daté, + affichage events
                        "semaine-type" : affichage du planning du lundi au dimanche + affichage events sans date.
                        "mois" : affichage du planning de la première semaine du mois complète à la dernière complète + affichage events
    ["h-deb"]       : "8"
    ["h-fin"]       : "23"
    ["tranche"]     : "4"

Requete API en javascript :
=========================

getEvents(String dateDeb, integer duree)         : Obtient la liste des events à partir de la date dateDeb pour une duree en jour. Format "2022-07-26" --}}

@props([
    'paras' => null,
    'events' => null,
    'id' => null,
])

<?php
$hauteurLigne4 = 40;
$hauteurLigne5 = $hauteurLigne4 / $paras['tranche'];
$nb_rows = ($paras['h-fin'] - $paras['h-deb']) * $paras['tranche']; // pour l'agenda
$ligneDouce = '#D5D8DC';
$ligneDure = '#808B96';

// switch($paras['role']){
//     case 'jour':
//         break;
//     case 'semaine-type':
//         break;
//     case 'semaine':
//         break;
//     case 'mois':
//         break;
// }

?>
<div class="cal" id="{{ $id }}">

    <div class="cal-1">
        Agenda
    </div>
    <div class="cal-2">
    </div>
    <div class="cal-3">
        <div class="">Lundi</div>
        <div class="">Mardi</div>
        <div class="">Mercredi</div>
        <div class="">Jeudi</div>
        <div class="">Vendredi</div>
        <div class="">Samedi</div>
        <div class="">Dimanche</div>
    </div>
    <div class="cal-4">
        @for ($h = $paras['h-deb']; $h <= $paras['h-fin']; $h += 1)
            <div class="cell-col1">
                <span>{{ $h }}h00</span>
            </div>
        @endfor
    </div>
    <div class="cal-5">
        @for ($h = 1; $h <= $nb_rows; $h += 1)
            @for ($j = 1; $j < 8; $j++)
                @if (fmod($h - 1, $paras['tranche']) == 0)
                    <?php $class = 'cell-cal-5-top'; ?>
                @elseif ($h == $nb_rows)
                    <?php $class = 'cell-cal-5-bottom'; ?>
                @else
                    <?php $class = 'cell-cal-5-middle'; ?>
                @endif
                @if ($j == 7)
                    <?php $class .= ' fermeture-droite'; ?>
                @endif

                <div id="{{ $j }}-{{ $h }}" class="cell {{ $class }}"
                    style="grid-row: {{ $h }};grid-column: {{ $j }}/{{ $j }};"
                    ondrop="drop(event)" ondragover="allowDrop(event)">
                </div>
            @endfor
        @endfor

        {{-- @foreach ($events as $event)
            <div id="{{ $event['titre'] }}" class="events  align-middle" draggable="true" ondragstart="drag(event)">
                {!! $event['titre'] !!}</div>
        @endforeach --}}

    </div>
</div>
<div class="row row-cols-lg-auto g-3 pb-2 align-items-center ">
    <div class="col-12 ">
        <select id="selJour" class="form-select">
            <option selected>Sélectionner le jour</option>
            <option value="0">Lundi</option>
            <option value="1">Mardi</option>
            <option value="2">Mercredi</option>
            <option value="3">Jeudi</option>
            <option value="4">Vendredi</option>
            <option value="5">Samedi</option>
            <option value="6">Dimanche</option>
        </select>
    </div>
    <div class="col-12 ">
        <input id="hDeb" type="time" class="form-control" id="inputHdeb" placeholder="" step="9000"
            min="08:00" max="23:00">
    </div>
    <div class="col-12 ">
        <input type="time" id="hFin" class="form-control" id="inputHfin" placeholder="" step="9000"
            min="08:00" max="23:00">
    </div>
    <div class="col-12 ">


        <button class="btn btn-primary" id="add">Ajouter une période</button>
    </div>

</div>
<div class="alert  alert-danger alert-dismissible " style="display:none;" role="alert" id="ZoneMessageErreur">
    <span id="messageErreur"></span>
    <button id="buttonCloseMessageErreur" type="button" class="btn-close" aria-label="Close"></button>
</div>


<style>
    .cal {
        display: grid;
        grid-template-columns: repeat(15, 1fr);


    }

    .cal-1 {
        grid-column: 1 / 16;
    }

    .cal-2 {
        grid-column: 1 / 2;
    }

    .cal-3 {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-auto-rows: 20px;
        grid-column: 2 / 16;

    }

    .cal-4 {
        display: grid;
        grid-column: 1 / 1;
        grid-auto-rows: {{ $hauteurLigne4 }}px;
        line-height: 0px;

    }

    .cal-5 {
        grid-column: 2 / 16;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-auto-rows: {{ $hauteurLigne5 }}px;
    }

    .events {
        background: #FEF9E7;
        border: 1px;
        border-style: solid;

    }



    .tranche_hauteur {
        height: 40px;
    }

    .jourSemaine {
        display: inline;
        width: 50px;
    }

    .cell-col1 {
        /* background: rgb(233, 203, 219); */

    }

    .cell-cal-5-top {
        border: 0px;
        border-left-width: 1px;
        border-top-width: 1px;
        border-style: solid;
        color: {{ $ligneDure }};
    }

    .cell-cal-5-middle {
        border: 0px;
        border-left-width: 1px;
        border-left-style: solid;
        border-left-color: {{ $ligneDure }};
        border-top-width: 1px;
        border-top-style: dotted;
        border-top-color: {{ $ligneDouce }};
    }

    .cell-cal-5-bottom {
        border: 0px;
        border-left-width: 1px;
        border-left-style: solid;
        border-left-color: {{ $ligneDure }};
        border-top-width: 1px;
        border-top-style: dotted;
        border-top-color: {{ $ligneDouce }};
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: {{ $ligneDure }};
    }

    .fermeture-droite {
        border-right-width: 1px;
        border-right-style: solid;
        border-right-color: {{ $ligneDure }};

    }
</style>
<script>
    $(document).ready(function() {

    })
    $(function() {
        $(".cell").on('click', function() {
            alert("ooo")
        })
    });

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        console.log(ev)
        ev.preventDefault();
        // var data = ev.dataTransfer.getData("text");
        // ev.target.appendChild(document.getElementById(data));
    }


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="/js/moment-round.min.js"></script>
<script src="/js/cal.js"></script>
