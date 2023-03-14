<?php
use Rras3k\SebconsoleRoot\facades\Core;
Core::init();
Core::setEntite();
?>
@extends('layouts.console')
@section('head-link')
@endsection

@section('content')
    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">Titre de la page</div>
        </div>

        {{-- Sert à centrer les panels inclus --}}
        <div class="§_panel_group">
            <div class="§_panel §_w_600">
                <div class="§_header">
                    Titre Panel...
                </div>
                <div class="§_rubrique">
                    Rubrique Panel...
                </div>
                <div class="§_content ">
                    Content ...</br>
                    Content ...</br>
                    Content ...</br>
                </div>
                <div class="§_rubrique">
                    Rubrique Panel...
                </div>
                <div class="§_content ">
                    Content ...</br>
                    Content ...</br>
                    Content ...</br>
                </div>
                <div class="§_footer">
                    Footer ...
                </div>
            </div>
        </div>
    </div>

    <html>
    {{-- Ici le style et la classe !!!! --}}

    </html>
    <script>
        // Ici les scripts
    </script>
@endsection
