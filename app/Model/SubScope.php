<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Scope;

class SubScope extends BaseModel
{
    protected $table = 'sub_scopes';

    protected $fillable = [
        'name',
        'code',
        'parameter',
        'is_active'
    ];

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
