<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'label_color',
        'directory'
    ];

    /**
     * Get the scores for the category.
     *
     * @return object
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get the scopes for the category.
     *
     * @return object
     */
    public function scopes()
    {
        return $this->hasMany(Scope::class);
    }

    /**
     * Scope a query to get category with the given name.
     *
     * @param string $query []
     * @param string $name []
     * @return object
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Scope a query to get category with the given slug.
     *
     * @param string $query []
     * @param string $slug []
     * @return object
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
