<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\JobInspect;

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
     * Test Relationship JobInspect with Issues
     *
     * @return void
     */
    public function testRelationshipWithIssues()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(HasMany::class, $job->issues());
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
