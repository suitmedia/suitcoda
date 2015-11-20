<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Inspection;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Url;

class JobInspect extends BaseModel
{
    protected $table = 'job_inspects';

    protected $fillable = [
        'command_line',
        'status',
        'check_count',
        'issue_count'
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
    }

    public function scopeGetUnhandledJob($query)
    {
        return $query->where('status', 0)->get();
    }
}
