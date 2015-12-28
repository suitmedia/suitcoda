<?php

namespace SuitTests\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Validation\Factory;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Http\Controllers\ProjectDetailController;
use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Issue;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;
use Suitcoda\Model\User;
use Suitcoda\Supports\CalculateScore;

class ProjectDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test continue if success go to page create
     *
     * @return void
     */
    public function testIntegrationCreate()
    {
        $projectFaker = factory(Project::class)->create();

        $this->actingAs($projectFaker->user)
             ->visit('project/' . $projectFaker->slug . '/inspect')
             ->see('Create New Inspection');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    /**
     * Test continue if success submit inspection
     *
     * @return void
     */
    public function testIntegrationStore()
    {
        $projectFaker = factory(Project::class)->create();

        $this->actingAs($projectFaker->user)
             ->visit('project/' . $projectFaker->slug . '/inspect')
             ->check('check-all')
             ->press('Inspect');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }
    
    /**
     * Test continue if success store inspection
     *
     * @return void
     */
    public function testUnitStoreInspectionNumberMoreThanOne()
    {
        $this->expectsEvents(ProjectWatcher::class);

        $inspectionFaker = factory(Inspection::class)->create([
            'status' => 2
        ]);

        $inspection = Mockery::mock(Inspection::class);
        $project = Mockery::mock(Project::class);
        $request = Mockery::mock(Request::class);
        $route = Mockery::mock(Route::class);

        $inspection->shouldReceive('newInstance')->once()->andReturn($inspectionFaker);
        $project->shouldReceive('findBySlug')->andReturn($inspectionFaker->project);
        $inspection->shouldReceive('completed');
        $request->shouldReceive('all')->andReturn(['scopes' => 'required']);
        $request->shouldReceive('route')->andReturn($route);
        $request->shouldReceive('input')->andReturn([1, 2, 4]);
        $route->shouldReceive('parameters');

        $controller = new ProjectDetailController($project, $inspection, new Scope);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->store($request));
    }

    /**
     * Test continue if success store inspection for first time
     *
     * @return void
     */
    public function testUnitStoreInspectionNumberEmpty()
    {
        $this->expectsEvents(ProjectWatcher::class);

        $inspectionFaker = factory(Inspection::class)->create();
        $projectFaker = factory(Project::class)->create();

        $inspection = Mockery::mock(Inspection::class);
        $project = Mockery::mock(Project::class);
        $request = Mockery::mock(Request::class);
        $route = Mockery::mock(Route::class);

        $inspection->shouldReceive('newInstance')->once()->andReturn($inspectionFaker);
        $project->shouldReceive('findBySlug')->andReturn($projectFaker);
        $request->shouldReceive('all')->andReturn(['scopes' => 'required']);
        $request->shouldReceive('route')->andReturn($route);
        $request->shouldReceive('input')->andReturn([1, 2, 4]);
        $route->shouldReceive('parameters');

        $controller = new ProjectDetailController($project, $inspection, new Scope);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->store($request));
    }

    /**
     * Test continue if sucess get json data
     *
     * @return void
     */
    public function testIntegrationGraph()
    {
        $inspectionFaker = factory(Inspection::class)->create();

        $this->actingAs($inspectionFaker->project->user)
             ->visit('project/' . $inspectionFaker->project->slug . '/graph')
             ->seeJson(['name' => 'Overall']);
        $this->assertResponseOk();
    }

    /**
     * Test continue if success go to page overview
     *
     * @return void
     */
    public function testIntegrationOverview()
    {
        $projectFaker = factory(Project::class)->create();

        $this->actingAs($projectFaker->user)
             ->visit('project/' . $projectFaker->slug . '/overview');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    /**
     * Test continue if success go to page issue
     *
     * @return void
     */
    public function testIntegrationIssue()
    {
        $projectFaker = factory(Project::class)->create();
        $inspectionFaker = factory(Inspection::class)->create([
            'project_id' => $projectFaker->id,
            'status' => 2
        ]);
        factory(Issue::class, 10)->create([
            'scope_id' => 1
        ]);

        $this->actingAs($projectFaker->user)
             ->visit('project/' . $projectFaker->slug . '/inspection-' . $inspectionFaker->sequence_number . '/SEO');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    /**
     * Test continue if success call activity method
     *
     * @return void
     */
    public function testUnitTestActivity()
    {
        $inspectionFaker = factory(Inspection::class)->create();

        $project = Mockery::mock(Project::class);
        $inspection = Mockery::mock(Inspection::class);
        $score = Mockery::mock(Score::class);
        $category = Mockery::mock(Category::class);
        $calc = Mockery::mock(CalculateScore::class . '[calculate]', [$score, $category]);
        $controller = Mockery::mock(ProjectDetailController::class . '[find]', [$project, $inspection, new Scope]);

        $project->shouldReceive('inspections->get')->andReturn(collect([$inspectionFaker]));
        $calc->shouldReceive('calculate');
        $controller->shouldReceive('find')->andReturn($project);

        $controller->activity(1, $calc);
    }
}
