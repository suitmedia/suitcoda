<?php

namespace SuitTests\Supports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Score;
use Suitcoda\Model\Url;
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
        $projectFaker = factory(Project::class)->create();
        $inspectionFaker = factory(Inspection::class)->create([
            'project_id' => $projectFaker->id
        ]);
        factory(JobInspect::class, 5)->create([
            'inspection_id' => $inspectionFaker->id,
            'scope_id' => 1,
            'issue_count' => 7,
            'status' => 2
        ]);
        factory(Url::class, 2)->create([
            'project_id' => $projectFaker->id
        ]);
        $score = Mockery::mock(Score::class);
        $category = Mockery::mock(Category::class);

        $score->shouldReceive('findOrNewByRelatedId')->andReturn(new Score);
        $score->shouldReceive('inspection->associate');
        $score->shouldReceive('save')->andReturn(true);
        $category->shouldReceive('all')->andReturn(Category::all());

        $calculateScore = new CalculateScore($score, $category);

        $calculateScore->calculate($inspectionFaker);
        $this->seeInDatabase('scores', [
            'category_id' => '1',
            'score' => 17.5
        ]);
    }
}
