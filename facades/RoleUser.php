<?php

namespace Rras3k\SebconsoleRoot\facades;

use Illuminate\Support\Facades\Facade;


class RoleUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RoleUser';
    }
}
