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
     *
     * @return void
     */
    public function testScopeGetUnhandledJob()
    {
        $job = new JobInspect;

        $this->assertNull($job->getUnhandledJob()->first());
    }

    /**
     * Test query scope of completed job
     *
     * @return void
     */
    public function testScopeCompletedJob()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'status' => 2
        ]);

        $this->assertInstanceOf(JobInspect::class, $jobFaker->completed()->first());
    }

    /**
     * Test scope a query to get job by category name.
     *
     * @return void
     */
    public function testScopeByCategoryName()
    {
        $jobFaker = factory(JobInspect::class)->create();

        $this->assertNull($jobFaker->byCategoryName('SEO')->first());
    }
}
