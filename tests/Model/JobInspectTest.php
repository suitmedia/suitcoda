<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\JobInspect;
use SuitTests\TestCase;

class JobInspectTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship JobInspect with Inspection
     *
     * @return void
     */
    public function testRelationshipWithInspection()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->inspection());
    }

    /**
     * Test Relationship JobInspect with Scope
     *
     * @return void
     */
    public function testRelationshipWithScope()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->scope());
    }

    /**
     * Test Relationship JobInspect with Url
     *
     * @return void
     */
    public function testRelationshipWithUrl()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->url());
    }

    /**
     * Test query scope of getUnhandledJob
     * @return void
     */
    public function testScopeGetUnhandledJob()
    {
        $job = new JobInspect;

        $this->assertNull($job->getUnhandledJob()->first());
    }
}
