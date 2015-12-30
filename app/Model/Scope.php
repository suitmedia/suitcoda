<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Category;
use Suitcoda\Model\Command;
use Suitcoda\Model\Issue;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\SubScope;

class Scope extends BaseModel
{
    protected $table = 'scopes';

    protected $fillable = [
        'type',
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
     * Get the jobInspects for the current scope.
     *
     * @return object
     */
    public function jobInspects()
    {
        return $this->hasMany(JobInspect::class);
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
     * Get the category for the current scope.
     *
     * @return object
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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
     * @param string $categoryId []
     * @return object
     */
    public function scopeByCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Get scope query by category name
     *
     * @param  string $query []
     * @param  string $name  []
     * @return object
     */
    public function scopeByCategoryName($query, $name)
    {
        return $query->whereHas('category', function ($query) use ($name) {
            $query->where('name', $name);
        });
    }

    /**
     * Get scope query by category slug
     *
     * @param  string $query []
     * @param  string $slug  []
     * @return object
     */
    public function scopeByCategorySlug($query, $slug)
    {
        return $query->whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        });
    }

    /**
     * Get shortcut to category name
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }
}
