<?php

namespace Rras3k\Console\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Rras3k\Console\app\Models\Role;
use Rras3k\Console\app\Models\Role_user;
use Illuminate\Support\Facades\Auth;


class RoleUser extends Model
{
    use HasFactory;


    private $listeRoleUser = [];

    public function __construct()
    {
        $this->listeRoleUser = Role_user::liste(Auth::user()->id);
    }

    public function roles()
    {

    }
    // public  function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public  function hasRole(String $role)
    {
        return isset($this->listeRoleUser[$role]);
        // return $this->roles()->where('nom', $role)->exists();
    }
    public function liste()
    {
        return [
            Role::ROOT => $this->isRoot(),
            Role::ADMIN => $this->isAdmin(),
            Role::CONSOLE => $this->isConsole(),
            Role::MEMBRE_1 => $this->isMember1(),
            Role::MEMBRE_2 => $this->isMember2(),
            Role::MEMBRE_3 => $this->isMember3(),
            Role::MEMBRE_4 => $this->isMember4(),
            Role::MEMBRE_5 => $this->isMember5(),
        ];
    }

    public  function isRoot()
    {
        return $this->HasRole('root');
    }
    public  function isAdmin()
    {
        return $this->HasRole('admin');
    }
    public  function isConsole()
    {
        return $this->HasRole('console');
    }
    public  function isMember1()
    {
        return $this->HasRole('member1');
    }
    public  function isMember2()
    {
        return $this->HasRole('member2');
    }
    public  function isMember3()
    {
        return $this->HasRole('member3');
    }
    public  function isMember4()
    {
        return $this->HasRole('member4');
    }
    public  function isMember5()
    {
        return $this->HasRole('member5');
    }
}
