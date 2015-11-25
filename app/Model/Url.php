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

    /**
     * Get the project for the current url.
     *
     * @return object
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Scope a query to get url with the given keyId.
     *
     * @param string $query []
     * @param string $keyId []
     * @return object
     */
    public function scopeByProjectId($query, $keyId)
    {
        return $query->where('project_id', $keyId);
    }

    /**
     * Scope a query to get url with the given url.
     *
     * @param string $query []
     * @param string $url []
     * @return object
     */
    public function scopeByUrl($query, $url)
    {
        return $query->where('url', $url);
    }

    /**
     * Scope a query to get active url.
     *
     * @param string $query []
     * @return object
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to get url with the given type.
     *
     * @param string $query []
     * @param string $type []
     * @return object
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
