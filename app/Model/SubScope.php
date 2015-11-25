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

    /**
     * Get the scope for the current subscope.
     *
     * @return object
     */
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
