<?php

namespace Suitcoda\Model;

use Cartalyst\Sentinel\Roles\EloquentRole as Model;
use Suitcoda\Model\Extension\SluggableTrait;

class Group extends Model
{
    use SluggableTrait;

    protected $slug_with = 'name';

    public function getRouteKey()
    {
        return $this->slug;
    }
}
