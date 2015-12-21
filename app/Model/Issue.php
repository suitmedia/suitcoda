<?php

namespace Suitcoda\Model;

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
}
