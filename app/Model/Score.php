<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Inspection;

class Score extends BaseModel
{
    protected $table = 'scores';

    protected $fillable = [
        'category',
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
}
