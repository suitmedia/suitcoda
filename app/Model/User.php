<?php

namespace Suitcoda\Model;

use Cartalyst\Sentinel\Users\EloquentUser as Model;

class User extends Model
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    /**
     * Array of login column names.
     *
     * @var array
     */
    protected $loginNames = ['username'];
}
