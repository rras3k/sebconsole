@props([
    'rank_max' => 5,
    'rank' => 0,
    'color' => 'black',
    'showNumeric' => false,
])
<?php
$half = false;
$nbEntier = floor($rank);
// echo $nbEntier;
$reste = $rank - $nbEntier;
if ($reste != 0) {
    if ($reste >= 0.75) {
        $nbEntier++;
    } elseif ($reste >= 0.25) {
        $half = true;
    }
}
$cpt = 0;
?>
@for ($i = 1; $i <= $nbEntier; $i++)
    <?php $cpt++; ?>
    <i class="bi bi-star-fill"></i>
@endfor
@if ($half)
    <?php $cpt++; ?>
    <i class="bi bi-star-half"></i>
@endif
@for ($i = $cpt; $i < $rank_max; $i++)
    <i class="bi bi-star"></i>
@endfor
@if ($showNumeric)
    ({{ $rank }})
@endif
