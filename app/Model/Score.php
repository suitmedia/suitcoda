<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Inspection;

class Score extends BaseModel
{
    protected $table = 'scores';

    protected $fillable = [
        'score'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
