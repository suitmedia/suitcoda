<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Issue;
use Suitcoda\Model\Score;

class InspectionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get string status attribute
     *
     * @return void
     */
    public function testGetStatusNameAttribute()
    {
        $inspection = new Inspection;

        $listStat = [
            (-1) => 'Stopped',
            0 => 'Waiting',
            1 => 'On Progress',
            2 => 'Completed'
        ];

        foreach ($listStat as $key => $value) {
            $inspection->status = $key;
            $this->assertEquals($value, $inspection->statusName);
        }
    }

    /**
     * Test get string status text color for frontend
     *
     * @return void
     */
    public function testGetStatusTextColorAttribute()
    {
        $inspection = new Inspection;

        $listStat = [
            (-1) => 'red',
            0 => 'grey',
            1 => 'orange',
            2 => 'green'
        ];

        foreach ($listStat as $key => $value) {
            $inspection->status = $key;
            $this->assertEquals($value, $inspection->statusTextColor);
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

    /**
     * Test get updated_at attribute with custom format
     *
     * @return void
     */
    public function testUpdatedAtFormat()
    {
        $inspection = new Inspection;
        $time = \Carbon\Carbon::now();
        $inspection->updated_at = $time;
        $this->assertEquals($time->diffForHumans(), $inspection->updated_at);
    }

    /**
     * Test get completed inspection by desc order
     *
     * @return void
     */
    public function testScopeLatestCompleted()
    {
        $inspection = new Inspection;

        $this->assertNull($inspection->latestCompleted()->first());

        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 2
        ]);

        $this->assertEquals($inspectionFaker->status, $inspectionFaker->latestCompleted()->first()->status);
    }

    /**
     * Test get inspection by given sequence number
     *
     * @return void
     */
    public function testScopeBySequenceNumber()
    {
        $inspection = new Inspection;

        $this->assertNull($inspection->bySequenceNumber(1)->first());

        $inspectionFaker = factory(Inspection::class)->create();

        $this->assertEquals(
            $inspectionFaker->sequence_number,
            $inspectionFaker->bySequenceNumber(1)->first()->sequence_number
        );
    }

    /**
     * Test get inspection score by given category name
     *
     * @return void
     */
    public function testGetScoreByCategory()
    {
        $inspection = new Inspection;

        $this->assertEquals('-', $inspection->getScoreByCategory('SEO'));

        $inspectionFaker = factory(Inspection::class)->create();
        factory(Score::class)->create([
            'inspection_id' => $inspectionFaker->id
        ]);

        $this->assertEquals('7%', $inspectionFaker->getScoreByCategory('test'));
    }

    /**
     * Test get inspection overall issue count
     *
     * @return void
     */
    public function testGetIssueAttribute()
    {
        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 0
        ]);
        $this->assertNull($inspectionFaker->issues);

        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 2
        ]);
        factory(Issue::class, 5)->create([
            'inspection_id' => $inspectionFaker->id
        ]);
        $this->assertEquals('5', $inspectionFaker->issues);
    }

    /**
     * Test get inspection issue list by given category name
     *
     * @return void
     */
    public function testGetIssueListByCategory()
    {
        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 0
        ]);
        $this->assertNull($inspectionFaker->getIssueListByCategory('SEO'));

        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 2
        ]);
        factory(Issue::class, 5)->create([
            'inspection_id' => $inspectionFaker->id
        ]);
        $this->assertInstanceOf(Collection::class, $inspectionFaker->getIssueListByCategory('SEO'));
    }

    /**
     * Test get inspection scopes list
     *
     * @return void
     */
    public function testGetScopeListAttribute()
    {
        $inspectionFaker = factory(Inspection::class)->create([
            'scopes' => 256
        ]);
        $this->assertEquals('SEO', $inspectionFaker->scopeList[0]->name);
    }

    /**
     * Test get inspection overall score
     *
     * @return void
     */
    public function testGetScore()
    {
        $inspectionFaker = factory(Inspection::class)->create([
            'score' => 100
        ]);
        $this->assertEquals(100, $inspectionFaker->score);
    }
}
