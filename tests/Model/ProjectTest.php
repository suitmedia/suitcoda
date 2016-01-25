<?php

namespace SuitTests\Model;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Issue;
use Suitcoda\Model\Project;
use Suitcoda\Model\Score;
use Suitcoda\Model\User;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get route key by slug
     *
     * @return void
     */
    public function testRouteKeyGetSlug()
    {
        $project = new Project;
        $project->slug = 'test';
        $this->assertEquals('test', $project->getRouteKey());
    }

    /**
     * Test get main url before set the value
     *
     * @return void
     */
    public function testMainUrlFormatBeforeSet()
    {
        $project = new Project;
        $this->assertEquals('http://', $project->main_url);
    }

    /**
     * Test get main url after set the value
     *
     * @return void
     */
    public function testMainUrlFormatAfterSet()
    {
        $project = new Project;
        $project->main_url = 'http://example.com';
        $this->assertEquals('http://example.com', $project->main_url);
    }

    /**
     * Test get updated_at attribute with custom format
     *
     * @return void
     */
    public function testUpdatedAtFormat()
    {
        $project = new Project;
        $time = \Carbon\Carbon::now();
        $project->updated_at = $time;
        $this->assertEquals($time->diffForHumans(), $project->updated_at);
    }

    /**
     * Test get query scope of search method
     *
     * @return void
     */
    public function testScopeSearch()
    {
        factory(Project::class)->create([
            'name' => 'test project'
        ]);

        $project = new Project;

        $this->assertEquals('test project', $project->search('test')->first()->name);
    }

    /**
     * Test get last inspection status on empty inspection
     *
     * @return void
     */
    public function testGetLastInspectionNumber()
    {
        $projectFaker = factory(Project::class)->create();

        $this->assertEquals('-', $projectFaker->lastInspectionNumber);

        $inspectionFaker = factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
        ]);
        $this->assertEquals('#' . $inspectionFaker->sequence_number, $projectFaker->lastInspectionNumber);
    }

    /**
     * Test get last inspection status on empty inspection
     *
     * @return void
     */
    public function testGetLastInspectionStatusNull()
    {
        $projectFaker = factory(Project::class)->create();

        $this->assertEquals('-', $projectFaker->lastInspectionStatus);
    }

    /**
     * Test get last inspection status != [1,2,3]
     *
     * @return void
     */
    public function testGetLastInspectionStatusDefault()
    {
        $projectFaker = factory(Project::class)->create();
        factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => (-1)
        ]);
        $this->assertEquals('<b class="text-red">Stopped</b>', $projectFaker->lastInspectionStatus);
    }

    /**
     * Test get last inspection status == 0
     *
     * @return void
     */
    public function testGetLastInspectionStatusWaiting()
    {
        $projectFaker = factory(Project::class)->create();
        factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 0
        ]);
        $this->assertEquals('<b class="text-grey">Waiting</b>', $projectFaker->lastInspectionStatus);
    }

    /**
     * Test get last inspection status == 1
     *
     * @return void
     */
    public function testGetLastInspectionStatusOnProgress()
    {
        $projectFaker = factory(Project::class)->create();
        factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 1
        ]);
        $this->assertEquals(
            '<b class="text-orange">On Progress</b>',
            $projectFaker->lastInspectionStatus
        );
    }

    /**
     * Test get last inspection status == 2
     *
     * @return void
     */
    public function testGetLastInspectionStatusCompleted()
    {
        $projectFaker = factory(Project::class)->create();
        factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 2
        ]);
        $this->assertEquals('<b class="text-green">Completed</b>', $projectFaker->lastInspectionStatus);
    }

    /**
     * Test get last completed inspection score
     *
     * @return void
     */
    public function testGetLastCompletedInspectionScoreAttribute()
    {
        $projectFaker = factory(Project::class)->create();
        
        $this->assertEquals('-', $projectFaker->lastCompletedInspectionScore);

        factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 2,
            'score' => 0.7
        ]);
        $this->assertEquals(70, $projectFaker->lastCompletedInspectionScore);
    }



    /**
     * Test get last completed inspection score by given category name
     *
     * @return void
     */
    public function testGetLastCompletedInspectionScoreByCategory()
    {
        $projectFaker = factory(Project::class)->create();
        
        factory(Score::class)->create([
            'inspection_id' => factory(Inspection::class)->create([
                'project_id' => $projectFaker->id,
                'status' => 2
            ])->id,
            'category_id' => 1,
            'score' => 0.7
        ]);
        $this->assertEquals(70, $projectFaker->getLastCompletedInspectionScoreByCategory('seo'));
        $this->assertEquals('-', $projectFaker->getLastCompletedInspectionScoreByCategory('performance'));
    }

    /**
     * Test get last completed inspection issue count by given category name
     *
     * @return void
     */
    public function testGetLastCompletedInspectionIssueByCategory()
    {
        $projectFaker = factory(Project::class)->create();
        
        factory(Issue::class)->create([
            'inspection_id' => factory(Inspection::class)->create([
                'project_id' => $projectFaker->id,
                'status' => 2
            ])->id,
            'scope_id' => 1,
        ]);
        $this->assertEquals(1, $projectFaker->getLastCompletedInspectionIssueByCategory('seo'));
        $this->assertEquals('-', $projectFaker->getLastCompletedInspectionIssueByCategory('performance'));
    }

    /**
     * Test to generate array for json data high-chart
     *
     * @return void
     */
    public function testGetJsonData()
    {
        $projectFaker = factory(Project::class)->create();

        $inspectionFaker = factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 2,
            'score' => 7
        ]);

        factory(Score::class)->create([
            'inspection_id' => $inspectionFaker->id,
        ]);

        $projectFaker->getJsonData();
    }

    public function testGetLastInspectionScoreWithScore()
    {
        $inspectionFaker = factory(Inspection::class)->create([
            'score' => 0.7
        ]);
        $project = Mockery::mock(Project::class . '[getLastInspection]');

        $project->shouldReceive('getLastInspection')->andReturn($inspectionFaker);

        $this->assertEquals('70%', $project->getLastInspectionScoreAttribute());
    }

    public function testGetLastInspectionScoreWithoutScore()
    {
        $project = Mockery::mock(Project::class . '[getLastInspection]');

        $project->shouldReceive('getLastInspection')->andReturn(null);

        $this->assertEquals('-', $project->getLastInspectionScoreAttribute());
    }

    public function testGetLastInspection()
    {
        $project = Mockery::mock(Project::class . '[inspections]');

        $project->shouldReceive('inspections->latest->first')->andReturn(true);

        $this->assertTrue($project->getLastInspection());
    }

    public function testGetLastCompletedInspection()
    {
        $project = Mockery::mock(Project::class . '[inspections]');

        $project->shouldReceive('inspections->latestCompleted->first')->andReturn(true);

        $this->assertTrue($project->getLastCompletedInspection());
    }

    public function testGetLastCompletedInspectionUrlPercentage()
    {
        $project = Mockery::mock(Project::class . '[getLastCompletedInspection]');
        $inspection = Mockery::mock(Inspection::class . '[uniqueUrlIssue, uniqueUrlJob]');

        $project->shouldReceive('getLastCompletedInspection')->andReturn($inspection);
        $inspection->shouldReceive('uniqueUrlIssue')->andReturn(5);
        $inspection->shouldReceive('uniqueUrlJob')->andReturn(10);

        $this->assertEquals('5/10', $project->getLastCompletedInspectionUrlPercentageAttribute());
    }

    public function testGetLastCompletedInspectionUrlPercentageWithNullObject()
    {
        $project = Mockery::mock(Project::class . '[getLastCompletedInspection]');

        $project->shouldReceive('getLastCompletedInspection')->andReturn(null);

        $this->assertEquals('-', $project->getLastCompletedInspectionUrlPercentageAttribute());
    }

    public function testGetLastCompletedInspectionUrlPercentageByCategory()
    {
        $project = Mockery::mock(Project::class . '[getLastCompletedInspection]');
        $inspection = Mockery::mock(Inspection::class . '[issues, uniqueUrlIssueByCategory, uniqueUrlJobByCategory]');

        $project->shouldReceive('getLastCompletedInspection')->andReturn($inspection);
        $inspection->shouldReceive('issues->byCategorySlug->get->isEmpty')->andReturn(false);
        $inspection->shouldReceive('uniqueUrlIssueByCategory')->andReturn(5);
        $inspection->shouldReceive('uniqueUrlJobByCategory')->andReturn(10);

        $this->assertEquals('5/10', $project->getLastCompletedInspectionUrlPercentageByCategory('seo'));
    }

    public function testGetLastCompletedInspectionUrlPercentageByCategoryWithNullObject()
    {
        $project = Mockery::mock(Project::class . '[getLastCompletedInspection]');

        $project->shouldReceive('getLastCompletedInspection')->andReturn(null);

        $this->assertEquals('-', $project->getLastCompletedInspectionUrlPercentageByCategory('seo'));
    }
}
