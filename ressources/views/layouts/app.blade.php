<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// dd(Auth()->user());

?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css"
        integrity="sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css"
        integrity="sha512-YFENbnqHbCRmJt5d+9lHimyEMt8LKSNTMLSaHjvsclnZGICeY/0KYEeiHwD1Ux4Tcao0h60tdcMv+0GljvWyHg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('head-link')

    @vite(['resources/js/app.js'])
    {{-- @vite(['resources/js/sb/bt.js']) --}}
</head>

<body>


    <header class="navbar sticky-top flex-md-nowrap p-0  pt-1 pb-1 ">
        <div class="text-light col-md-3 col-lg-2 me-0 px-3 fs-6 text-center">
            @if (config('sebconsole.affiche_logo'))
                <img src="/img/logo.png" width="175">
            @else
                {{ env('APP_NAME') }}
            @endif
        </div>
        {{-- <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <div class="col">
            {{-- <a role="button" class="btn btn-outline-light border-0 ms-1" href="{{ route('home') }}">Home visiteur</a> --}}

            {{-- Afficage du lien vers le document central du projet --}}
            {{-- @if (config('console.url_doc'))
                <a role="button" class="btn btn-outline-light border-0" target="_blank"
                    href="{{ config('console.url_doc') }}">Doc
                    central</a>
            @endif --}}
            <button class="navbar-toggler position-absolute d-md-none collapsed top-0 end-0 header_burger "
                type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="dropstart position-absolute d-none d-md-block top-0 end-0 header-div">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ Auth()->user()->name }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Mon profil</a></li>
                    <li>
                        <a class="nav-link px-3" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Déconnection
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
    </header>


    <div class="container-fluide">
        <div class="row" style="--bs-gutter-x:0rem !important;">
            <nav id="sidebarMenu" class="col-md-3 g-0 col-lg-2 d-md-block  sidebar collapse">
                @include('sebconsoleviews::menu')
            </nav>
            <div class="offset-md-3 col-md-9  offset-lg-2 col-lg-10 g-0 p-0">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script> --}}

    @yield('foot-link')

</body>

</html>
