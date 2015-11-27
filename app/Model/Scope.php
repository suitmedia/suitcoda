<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Command;
use Suitcoda\Model\Issue;
use Suitcoda\Model\SubScope;

class Scope extends BaseModel
{
    protected $table = 'scopes';

    protected $fillable = [
        'type',
        'category',
        'name',
        'is_active'
    ];

    /**
     * Get the command for the current scope.
     *
     * @return object
     */
    public function command()
    {
        return $this->hasOne(Command::class);
    }

    /**
     * Get the issues for the current scope.
     *
     * @return object
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * Get the subscopes for the current scope.
     *
     * @return object
     */
    public function subScopes()
    {
        return $this->hasMany(SubScope::class);
    }

    /**
     * Scope a query to get scope with the given name.
     *
     * @param string $query []
     * @param string $name []
     * @return object
     */
    public function scopeGetByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    /**
     * Scope a query to get project with the given type.
     *
     * @param string $query []
     * @param string $type []
     * @return object
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to get project with the given category.
     *
     * @param string $query []
     * @param string $category []
     * @return object
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
