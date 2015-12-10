<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
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
}
