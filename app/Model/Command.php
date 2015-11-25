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

    /**
     * Get the scope for the command.
     *
     * @return object
     */
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
