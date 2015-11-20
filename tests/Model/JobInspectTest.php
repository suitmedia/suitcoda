<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\JobInspect;

class JobInspectTest extends TestCase
{
    use DatabaseTransactions;

    public function testRelationshipWithInspection()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->inspection());
    }

    public function testRelationshipWithScope()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->scope());
    }

    public function testRelationshipWithUrl()
    {
        $job = new JobInspect;

        $this->assertInstanceOf(BelongsTo::class, $job->url());
    }

    public function testScopeGetUnhandledJob()
    {
        $job = new JobInspect;

        $this->assertNull($job->getUnhandledJob()->first());
    }
}
