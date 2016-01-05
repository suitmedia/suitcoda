<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Issue;

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

    /**
     * Test get updated_at attribute with custom format
     *
     * @return void
     */
    public function testCreatedAtFormat()
    {
        $issue = new Issue;
        $time = \Carbon\Carbon::now();
        $issue->updated_at = $time;
        $this->assertEquals($time->diffForHumans(), $issue->created_at);
    }

    /**
     * Test get query scope of categoryByName method
     *
     * @return void
     */
    public function testScopeByCategoryName()
    {
        $issue = new Issue;

        $this->assertInstanceOf(Collection::class, $issue->byCategoryName('SEO')->get());
    }

    /**
     * Test get query scope of categoryBySlug method
     *
     * @return void
     */
    public function testScopeByCategorySlug()
    {
        $issue = new Issue;

        $this->assertInstanceOf(Collection::class, $issue->byCategorySlug('SEO')->get());
    }

    /**
     * Test to check type attribute is error
     *
     * @return void
     */
    public function testTypeIsError()
    {
        $issueFaker = factory(Issue::class)->create();

        $this->assertTrue($issueFaker->isError());
    }

    /**
     * Test to check type attribute is not error
     *
     * @return void
     */
    public function testTypeIsNotError()
    {
        $issueFaker = factory(Issue::class)->create([
            'type' => 'warning'
        ]);

        $this->assertFalse($issueFaker->isError());
    }

    /**
     * Test type attribute
     *
     * @return void
     */
    public function testGetTypeAttribute()
    {
        $issueFaker = factory(Issue::class)->create();

        $this->assertEquals('Error', $issueFaker->type);
    }
}
