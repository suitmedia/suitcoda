<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\SubScope;
use SuitTests\TestCase;

class SubScopeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship SubScope with Scope
     *
     * @return void
     */
    public function testRelationshipWithScope()
    {
        $subScope = new SubScope;

        $this->assertInstanceOf(BelongsTo::class, $subScope->scope());
    }
}
