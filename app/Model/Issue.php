<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Scope;

class Issue extends BaseModel
{
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

    public function isError()
    {
        if (strcasecmp($this->attributes['type'], 'error') == 0) {
            return true;
        }
        return false;
    }

    public function getTypeAttribute()
    {
        return ucwords($this->attributes['type']);
    }
}
