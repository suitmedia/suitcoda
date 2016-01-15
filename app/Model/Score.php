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
     * Get scope query of score by related id
     *
     * @param  string $query        []
     * @param  string $inspectionId []
     * @param  string $categoryId   []
     * @return object
     */
    public function scopeByRelatedId($query, $inspectionId, $categoryId)
    {
        return $query->where('inspection_id', $inspectionId)->where('category_id', $categoryId);
    }

    /**
     * Find or create model by related id
     * @param  string $inspectionId []
     * @param  string $categoryId   []
     * @return object
     */
    public function findOrNewByRelatedId($inspectionId, $categoryId)
    {
        if ($this->byRelatedId($inspectionId, $categoryId)->first()) {
            return $this->byRelatedId($inspectionId, $categoryId)->first();
        }
        return $this->newInstance();
    }
}
