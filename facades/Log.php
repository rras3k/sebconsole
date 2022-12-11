<?php

namespace Rras3k\SebconsoleRoot\facades;

use Illuminate\Support\Facades\Facade;


class Log extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Log';
    }
}
