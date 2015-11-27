<?php

namespace Suitcoda\Model;

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
     * Get the scope for the current scope.
     *
     * @return object
     */
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
