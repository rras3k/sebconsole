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
        $this->listeRoleUser = $this->listeInit(Auth::user()->id);
    }
    public function liste(){
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

    public  function hasRole(String $role)
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
