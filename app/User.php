<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',  'funcao',  'CredPortId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->funcao == 1 ? true : false; // this looks for an admin column in your users table
    }
    public function isMaster()
    {
        return $this->funcao == 2 ? true : false; // this looks for an admin column in your users table
    }
    public function isServidor()
    {
        return $this->funcao == 3 ? true : false; // this looks for an admin column in your users table
    }
    public function isCidadao()
    {
        return $this->funcao == 4 ? true : false; // this looks for an admin column in your users table
    }
}
