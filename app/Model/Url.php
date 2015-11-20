<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Project;

class Url extends BaseModel
{
    protected $table = 'urls';

    protected $fillable = [
        'type',
        'url',
        'depth',
        'title',
        'title_tag',
        'desc',
        'desc_tag',
        'body_content',
        'is_active',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeByProjectId($query, $id)
    {
        return $query->where('project_id', $id);
    }

    public function scopeByUrl($query, $url)
    {
        return $query->where('url', $url);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
