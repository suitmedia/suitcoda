<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Command;
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

    public function subScopes()
    {
        return $this->hasMany(SubScope::class);
    }

    public function command()
    {
        return $this->hasOne(Command::class);
    }

    public function scopeGetByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
