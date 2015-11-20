<?php

namespace Suitcoda\Model;

use Suitcoda\Model\Scope;

class Command extends BaseModel
{
    protected $table = 'commands';

    protected $fillable = [
        'name',
        'command_line',
        'is_active'
    ];

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
