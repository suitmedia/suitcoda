<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;

class Score extends BaseModel
{
    protected $table = 'scores';

    protected $fillable = [
        'score'
    ];

    /**
     * Get the inspection for the current score.
     *
     * @return object
     */
    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    /**
     * Get the category for the current score.
     *
     * @return object
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
