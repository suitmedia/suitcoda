<?php

namespace Suitcoda\Model;

use Cartalyst\Sentinel\Roles\EloquentRole as Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Group extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug',
    ];

    /**
     * Return wildcard in route with slug
     * @return string
     */
    public function getRouteKey()
    {
        return $this->slug;
    }
}
