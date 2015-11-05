<?php

namespace Suitcoda\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Suitcoda\Model\Project;

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
        'password', 'remember_token'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

    // public function setPasswordAttribute($value)
    // {
    //     if (!empty($value) || is_numeric($value)) {
    //         $this->attributes[ 'password' ] = bcrypt($value);
    //     }
    // }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getLastLoginAtAttribute($value)
    {
        if ($value) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i M j, Y');
            return $time;
        }
        return '-';
    }

    public function isAdmin()
    {
        if ($this->is_admin) {
            return true;
        }
        return false;
    }

    public function getAdminName()
    {
        if ($this->is_admin) {
            return 'Admin';
        }
        return 'User';
    }

    public function getInitials()
    {
        $words = explode(' ', $this->name);
        $initial = '';
        $count = 2;
        foreach ($words as $word) {
            if ($count > 0) {
                $initial .= $word[0];
                $count--;
            }
        }
        return strtoupper($initial);
    }

    public function login()
    {
        $this->last_login_at = Carbon::now();
        $this->save();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    public function scopeAllAccount($query)
    {
        return $query->orderBy('name')->get();
    }
}
