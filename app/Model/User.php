<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Suitcoda\Model\Project;

class User extends BaseModel implements SluggableInterface, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;
    use CanResetPassword;
    use SluggableTrait;

    protected $table = 'users';

    protected $urlKey = 'slug';

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

    /**
     * Get sentence case for name atrribute
     * @param  string $value []
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get last_login_at attribute with the custom format
     *
     * @param  string $value []
     * @return string
     */
    public function getLastLoginAtAttribute($value)
    {
        if ($value) {
            $time = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i M j, Y');
            return $time;
        }
        return '-';
    }

    /**
     * Get is_admin attribute boolean value
     *
     * @return bool
     */
    public function isAdmin()
    {
        if ($this->is_admin) {
            return true;
        }
        return false;
    }

    /**
     * Get is_admin attribute string value
     *
     * @return string
     */
    public function getAdminName()
    {
        if ($this->is_admin) {
            return 'Admin';
        }
        return 'User';
    }

    /**
     * Get initial of name attribute
     *
     * @return string
     */
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

    /**
     * Save user login's time
     * @return void
     */
    public function login()
    {
        $this->last_login_at = Carbon::now();
        $this->save();
    }
    /**
     * Get the project for the current user.
     *
     * @return object
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    /**
     * Scope a query to get all user with ascending order by name.
     *
     * @param string $query []
     * @return object
     */
    public function scopeAllAccount($query)
    {
        return $query->orderBy('name')->get();
    }
}
