<?php

namespace Rras3k\SebconsoleRoot\facades;

use Illuminate\Support\Facades\Facade;


class ViewData extends Facade
{
    protected static function getFacadeAccessor()
    {
        // dd('yy');
        return 'ViewData';
    }
}
