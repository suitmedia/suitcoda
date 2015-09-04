<?php

namespace Suitcoda\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements SluggableInterface, AuthenticatableContract, CanResetPasswordContract
{
    use SluggableTrait, Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $url_key = 'slug';

    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'slug',
        'date_of_birth',
        'is_admin',
        'is_active',
    ];

    protected $hidden = [
        'password'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value) || is_numeric($value)) {
            $this->attributes[ 'password' ] = bcrypt($value);
        }
    }

    public function login()
    {
        $this->last_login_at = Carbon::now();
        $this->save();
    }
}
