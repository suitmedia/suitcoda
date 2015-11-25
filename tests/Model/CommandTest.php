<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Command;
use SuitTests\TestCase;

class CommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Command with scope
     *
     * @return void
     */
    public function testRelationshipWithScope()
    {
        $command = new Command;

        $this->assertInstanceOf(BelongsTo::class, $command->scope());
    }
}
