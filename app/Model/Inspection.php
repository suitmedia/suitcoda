<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Project;

class Inspection extends BaseModel
{
    protected $table = 'inspections';

    protected $fillable = [
        'sequence_number',
        'scopes',
        'status',
        'score',
    ];

    public function scopeGetLatestByProjectId($query, $id)
    {
        return $query->where('project_id', $id)->latest()->first();
    }

    public function scopeGetAllByProjectId($query, $id)
    {
        return $query->where('project_id', $id)->get();
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id)->get();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

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
