<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Scope;

class Issue extends BaseModel
{
    const ERROR = 'error';

    protected $table = 'issues';

    protected $fillable = [
        'type',
        'url',
        'description',
        'issue_line'
    ];

    /**
     * Get the jobInspect for the current issue.
     *
     * @return object
     */
    public function jobInspect()
    {
        return $this->belongsTo(JobInspect::class);
    }

    /**
     * Get the scope for the current issue.
     *
     * @return object
     */
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    /**
     * Get the inspection for the current issue.
     *
     * @return object
     */
    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    /**
     * Get updated_at variable with the given format
     *
     * @param  string $value []
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        $time = new Carbon($value);
        return $time->diffForHumans();
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
        return $query->whereHas('scope', function ($query) use ($name) {
            $query->byCategoryName($name);
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
        return $query->whereHas('scope', function ($query) use ($slug) {
            $query->byCategorySlug($slug);
        });
    }

    public function scopeError($query)
    {
        return $query->where('type', self::ERROR);
    }

    /**
     * Check if type is error
     *
     * @return bool
     */
    public function isError()
    {
        if (strcasecmp($this->attributes['type'], self::ERROR) == 0) {
            return true;
        }
        return false;
    }

    /**
     * Make type attribute sentence case
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return ucwords($this->attributes['type']);
    }
}
