<?php

namespace App\Models;

use  Rras3k\Sebconsole\Models\SbModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Role extends SbModel
{
    use HasFactory;

    public  const ROOT = 1;
    public  const ADMIN = 2;
    public  const CONSOLE = 3;
    public  const MEMBRE_1 = 4;
    public  const MEMBRE_2 = 5;
    public  const MEMBRE_3 = 6;
    public  const MEMBRE_4 = 7;
    public  const MEMBRE_5 = 8;

    protected $fillable = ['nom', 'fonction'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    //--- Mvc
    public static function getStrName()
    {
        return 'nom';
    }
    public static function getLabel()
    {
        return 'Role';
    }
    public static function getList()
    {
        return Role::select(['id', 'nom as label'])->where('enable', '=', 1)->orderBy('nom', 'asc')->get();
    }

}
