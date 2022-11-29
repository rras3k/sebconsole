<?php

namespace Rras3k\Console\facades;

use Illuminate\Support\Facades\Facade;


class MenuMaker extends Facade
{
    protected static function getFacadeAccessor()
    {
        // dd('yy');
        return 'MenuMaker';
    }
}
