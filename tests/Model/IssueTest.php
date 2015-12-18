<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Issue;
use SuitTests\TestCase;

class IssueTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Issue with JobInspect
     *
     * @return void
     */
    public function testRelationshipWithJobInspect()
    {
        $issue = new Issue;

        $this->assertInstanceOf(BelongsTo::class, $issue->jobInspect());
    }

    /**
     * Test Relationship Issue with Scope
     *
     * @return void
     */
    public function testRelationshipWithScope()
    {
        $issue = new Issue;

        $this->assertInstanceOf(BelongsTo::class, $issue->scope());
    }

    /**
     * Test Relationship Issue with Inspection
     *
     * @return void
     */
    public function testRelationshipWithInspection()
    {
        $issue = new Issue;

        $this->assertInstanceOf(BelongsTo::class, $issue->inspection());
    }
}
