<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\SubScope;

class SubScopeTest extends TestCase
{
    use DatabaseTransactions;

    public function testRelationshipWithScope()
    {
        $subScope = new SubScope;

        $this->assertInstanceOf(BelongsTo::class, $subScope->scope());
    }
}
