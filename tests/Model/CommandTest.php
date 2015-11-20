<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Command;

class CommandTest extends TestCase
{
    use DatabaseTransactions;

    public function testRelationshipWithScope()
    {
        $command = new Command;

        $this->assertInstanceOf(BelongsTo::class, $command->scope());
    }
}
