<?php

namespace SuitTests\Supports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;
use Suitcoda\Supports\CalculateScore;

class CalculateScoreTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test add score to database
     *
     * @return void
     */
    public function testAddScore()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(JobInspect::class, 5)->create([
            'inspection_id' => $inspectionFaker->id,
            'scope_id' => 1,
            'issue_count' => 7,
            'status' => 2
        ]);
        $score = Mockery::mock(Score::class);
        $scope = Mockery::mock(Scope::class);

        $score->shouldReceive('newInstance')->andReturn(new Score);
        $score->shouldReceive('inspection->associate');
        $score->shouldReceive('save')->andReturn(true);
        $scope->shouldReceive('all->pluck')->andReturn(new Collection(['SEO', 'Code Quality']));

        $calculateScore = new CalculateScore($score, $scope);

        $calculateScore->calculate($inspectionFaker);
        $this->seeInDatabase('scores', [
            'category' => 'SEO',
            'score' => 7
        ]);
    }

    /**
     * Test call calculate method with empty job
     *
     * @return void
     */
    public function testCallCalculateForEmptyJob()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(JobInspect::class, 2)->create([
            'inspection_id' => $inspectionFaker->id,
            'issue_count' => 7,
            'scope_id' => 1,
            'status' => 1
        ]);
        $score = Mockery::mock(Score::class);
        $calculateScore = new CalculateScore($score, new Scope);

        $calculateScore->calculate($inspectionFaker);
    }
}