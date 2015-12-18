<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Issue;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Score;

class Inspection extends BaseModel
{
    protected $table = 'inspections';

    protected $fillable = [
        'sequence_number',
        'scopes',
        'status',
        'score',
    ];

    /**
     * Scope a query to only include inspections of a given projectId.
     *
     * @param  string $query []
     * @param  string $projectId []
     * @return object
     */
    public function scopeGetLatestByProjectId($query, $projectId)
    {
        return $query->where('project_id', $projectId)->latest()->first();
    }

    /**
     * Scope a query to get all inspections of a given projectId.
     *
     * @param  string $query []
     * @param  string $projectId []
     * @return object
     */
    public function scopeGetAllByProjectId($query, $projectId)
    {
        return $query->where('project_id', $projectId)->get();
    }

    /**
     * Scope a query to get inspections of a given id.
     *
     * @param  string $query []
     * @param  string $keyId []
     * @return object
     */
    public function scopeGetById($query, $keyId)
    {
        return $query->where('id', $keyId)->get();
    }

    /**
     * Get the project for the current inspection.
     *
     * @return object
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the jobInspects for the current inspection.
     *
     * @return object
     */
    public function jobInspects()
    {
        return $this->hasMany(JobInspect::class);
    }

    /**
     * Get the scores for the current inspection.
     *
     * @return object
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get the issues for the current inspection.
     *
     * @return object
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * Get status attribute in string
     *
     * @return string
     */
    public function getStatAttribute()
    {
        if ($this->attributes['status'] == 0) {
            return 'Queue';
        }
        if ($this->attributes['status'] == 1) {
            return 'Process';
        }
        if ($this->attributes['status'] == 2) {
            return 'Completed';
        }
        return 'Unknown';
    }
}
