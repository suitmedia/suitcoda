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

    public function scopeByInspectionId($query, $inspectionId)
    {
        return $query->where('inspection_id', $inspectionId);
    }

    public function findOrNewByInspectionId($inspectionId)
    {
        if ($this->byInspectionId($inspectionId)->first()) {
            return $this->byInspectionId($inspectionId)->first();
        }
        return $this->newInstance();
    }
}
