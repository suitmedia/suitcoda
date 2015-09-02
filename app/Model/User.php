<?php

namespace Suitcoda\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;

class User extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'users';

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

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

    /**
     * Return wildcard in route with slug
     * @return string
     */
    public function getRouteKey()
    {
        return $this->slug;
    }

    /**
     * Get the table qualified key name.
     *
     * @return string
     */
    public function getQualifiedKeyName()
    {
        return $this->getTable().'.'.'slug';
    }

    protected $hidden = [
        'password', 'remember_token'
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
