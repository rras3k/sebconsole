<?php

namespace Rras3k\Console\facades;

use Illuminate\Support\Facades\Facade;


class RoleUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        // dd('yy');
        return 'RoleUser';
    }
}
