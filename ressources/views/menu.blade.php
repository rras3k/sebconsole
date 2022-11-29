<?php

use Rras3k\Console\app\Models\AuthRole;
use Rras3k\Console\facades\MenuMaker;

$menus = MenuMaker::get();

?>

    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            @if (config('console.affiche_icon_libre'))
                <div class="row w-100 ms-auto me-auto">
                    @foreach ($menus as $fav)
                        @if ($fav['enable'])
                            <div class="col-xxl-2 col-md-3  container-fav">
                                <a href="{{ route($fav['route']) }}" class="a-icon-fav" title="{{ $fav['nom'] }}">
                                    <i class="icon-fav fa-xl fa-solid {{ $fav['icon'] }}"></i>
                                </a>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-xxl-2 col-md-3  container-fav">
                        <a class="a-icon-fav" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon-fav fa-xl fa-solid fa-right-from-bracket"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                </div>
            @endif


                @php
                    $ctp = 1;
                    $accordeonAuMoinsUn =false;
                    $rubriqueLive ='';
                @endphp
                @foreach ($menus as  $menu)
                    @if ($menu['enable'])

                        @if (config('console.menu_accordeon',false))

                            @if ($rubriqueLive != $menu['rubrique'])
                                @if($accordeonAuMoinsUn)
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="accordion accordion-flush" id="accordionMain">
                                @php
                                    $accordeonAuMoinsUn=true;
                                @endphp

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $ctp }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $ctp }}" aria-expanded="true"
                                            aria-controls="collapse{{ $ctp }}">
                                            {{ $menu['rubrique'] }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $ctp }}" class="accordion-collapse collapse accordion-flush"
                                        aria-labelledby="heading{{ $ctp }}"
                                        data-bs-parent="#accordion{{ $ctp }}">
                                        <div class="accordeion-body">
                            @endif

                            {{-- Element d'une rubrique --}}
                                            <li class="nav-item">
                                                <a class="nav-link" aria-current="page"
                                                    href="{{ route($menu['route']) }}" sb-route="dashboard.index">
                                                    <i class="fa-solid {{ $menu['icon'] }} w-icon"></i>
                                                    {{ $menu['nom'] }}
                                                </a>
                                            </li>

                        @endif

                        @if (!config('console.menu_accordeon',false))
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route($menu['route']) }}"
                                        sb-route="dashboard.index">
                                        <i class="fa-solid {{ $menu['icon'] }} w-icon"></i>
                                        {{ $menu['nom'] }}
                                    </a>
                                </li>
                        @endif

                        @php
                            $rubriqueLive = $menu['rubrique'];
                            $ctp++;

                        @endphp

                    @endif
                @endforeach
                @if (config('console.menu_accordeon',false))
                            </div>
                        </div>
                    </div>
                @endif

            </div>



            <li class="nav-item">
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

    <style>
        .w-icon {
            width: 25px;
        }

        .a-icon-fav {
            color: #6c757d;
        }

        .a-icon-fav:hover {
            color: black;
            /* background:#6c757d; */
        }

        .icon-fav {
            width: 100%;
        }

        .container-fav {
            text-align: center;
            margin-top: 7px;
            margin-bottom: 7px;
            /* border: 1px solid gray; */
        }

        li a:hover {
            background-color: rgba(114, 159, 159, 0.173);
        }
    </style>
    <script>
        $(document).ready(function() {
            menu = $('a[sb-route|="{{ Route::currentRouteName() }}"').addClass("active")
        })
    </script>
