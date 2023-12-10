<?php

namespace Rras3k\Sebconsole\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

// class User extends SbModel
trait User
{
    public function roles()
    {
        return $this->belongsToMany((Role::class));
    }

    public function HasRole(string $role)
    {
        return $this->roles()->where('nom', $role)->exists();
    }

    public function isAdmin()
    {
        return $this->HasRole('admin');
    }
    public function isRoot()
    {
        return $this->HasRole('root');
    }
    public function isAdminOrRoot()
    {
        return $this->HasRole('root') || $this->HasRole('admin');
    }

    public function isConsole()
    {
        return $this->HasRole('console');
    }
    public function isEtablissement()
    {
        return $this->HasRole('etablissement');
    }
    public function isMember()
    {
        return $this->HasRole('member');
    }
}
