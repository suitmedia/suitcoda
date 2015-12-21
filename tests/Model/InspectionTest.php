<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Inspection;
use SuitTests\TestCase;

class InspectionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get string status attribute
     *
     * @return void
     */
    public function testGetStatAttribute()
    {
        $inspection = new Inspection;

        $listStat = [
            (-1) => 'Unknown',
            0 => 'Queue',
            1 => 'Process',
            2 => 'Completed'
        ];

        foreach ($listStat as $key => $value) {
            $inspection->status = $key;
            $this->assertEquals($value, $inspection->stat);
        }
    }

    /**
     * Test Relationship Inspection with Project
     *
     * @return void
     */
    public function testRelationshipWithProject()
    {
        $inspection = new Inspection;

        $this->assertInstanceOf(BelongsTo::class, $inspection->project());
    }

    /**
     * Test Relationship Inspection with JobInspects
     *
     * @return void
     */
    public function testRelationshipWithJobInspects()
    {
        $inspection = new Inspection;

        $this->assertInstanceOf(HasMany::class, $inspection->jobInspects());
    }

    /**
     * Test Relationship Inspection with Score
     *
     * @return void
     */
    public function testRelationshipWithScore()
    {
        $inspection = new Inspection;

        $this->assertInstanceOf(HasMany::class, $inspection->scores());
    }

    /**
     * Test Relationship Inspection with Issue
     *
     * @return void
     */
    public function testRelationshipWithIssue()
    {
        $inspection = new Inspection;

        $this->assertInstanceOf(HasMany::class, $inspection->issues());
    }

    /**
     * Test get query scope of getById method
     *
     * @return void
     */
    public function testScopeGetById()
    {
        $inspection = new Inspection;

        $this->assertEquals(new Collection, $inspection->getById(1));
    }
}
