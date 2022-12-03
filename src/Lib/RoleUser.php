<?php

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Rras3k\Sebconsole\Models\Role;
use Rras3k\Sebconsole\Models\Role_user;
use Illuminate\Support\Facades\Auth;




class RoleUser extends Model
{
    use HasFactory; 


    private $listeRoleUser = [];

    public function __construct()
    {
        if (isset(Auth::user()->id))
            $this->listeRoleUser = $this->listeInit(Auth::user()->id);
    }
    public function liste()
    {
        return $this->listeRoleUser;
    }
    public function listeInit($userId)
    {
        $table = new Role();
        // dd($table->leftjoin('role_user', 'role_user.role_id', '=', 'roles.id')->where('user_id', $userId)->toSql());

        // return $table->leftjoin('role_user', 'role_user.role_id', '=', 'roles.id')->where('user_id', $userId)->get()->keyBy('nom')->toArray();

        return $table->leftjoin('role_user', 'role_user.role_id', '=', 'roles.id')->where('user_id', $userId)->get()->keyBy('role_id')->toArray();
    }
    public function roles()
    {
    }
    // public  function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public  function hasRole($role)
    {
        return isset($this->listeRoleUser[$role]);
        // return $this->roles()->where('nom', $role)->exists();
    }
    public function listeOld()
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
        return $this->HasRole(Role::ROOT);
    }
    public  function isAdmin()
    {
        return $this->HasRole(Role::ADMIN);
    }
    public  function isConsole()
    {
        return $this->HasRole(Role::CONSOLE);
    }
    public  function isMember1()
    {
        return $this->HasRole(Role::MEMBRE_1);
    }
    public  function isMember2()
    {
        return $this->HasRole(Role::MEMBRE_2);
    }
    public  function isMember3()
    {
        return $this->HasRole(Role::MEMBRE_3);
    }
    public  function isMember4()
    {
        return $this->HasRole(Role::MEMBRE_4);
    }
    public  function isMember5()
    {
        return $this->HasRole(Role::MEMBRE_5);
    }
}
