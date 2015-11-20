<?php

namespace SuitTests\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Validation\Factory;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Http\Controllers\InspectionController;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\User;

class InspectionControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIntegrationStore()
    {
        $userFaker = factory(User::class)->create();
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);

        $this->actingAs($userFaker)
             ->visit('project/' . $projectFaker->slug)
             ->check('check-all')
             ->press('Inspect')
             ->seePageIs('project/' . $projectFaker->slug);
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }
    
    public function testUnitStoreInspectionNumberMoreThanOne()
    {
        $this->expectsEvents(ProjectWatcher::class);

        $userFaker = factory(User::class)->create();
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        $inspectionFaker = factory(Inspection::class)->make();
        $projectFaker->inspections()->save($inspectionFaker);

        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $project = Mockery::mock(Project::class)->makePartial();
        $request = Mockery::mock(Request::class)->makePartial();
        $route = Mockery::mock(Route::class)->makePartial();

        $inspection->shouldReceive('newInstance')->once()->andReturn($inspectionFaker);
        $project->shouldReceive('findBySlug')->andReturn($projectFaker);
        $request->shouldReceive('all')->andReturn(['scopes' => 'required']);
        $request->shouldReceive('route')->andReturn($route);
        $request->shouldReceive('input')->andReturn([1, 2, 4]);
        $route->shouldReceive('parameters');

        $controller = new InspectionController($inspection, $project);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->store($request));
    }

    public function testUnitStoreInspectionNumberEmpty()
    {
        $this->expectsEvents(ProjectWatcher::class);

        $userFaker = factory(User::class)->create();
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        $inspectionFaker = factory(Inspection::class)->make();

        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $project = Mockery::mock(Project::class)->makePartial();
        $request = Mockery::mock(Request::class)->makePartial();
        $route = Mockery::mock(Route::class)->makePartial();

        $inspection->shouldReceive('newInstance')->once()->andReturn($inspectionFaker);
        $project->shouldReceive('findBySlug')->andReturn($projectFaker);
        $request->shouldReceive('all')->andReturn(['scopes' => 'required']);
        $request->shouldReceive('route')->andReturn($route);
        $request->shouldReceive('input')->andReturn([1, 2, 4]);
        $route->shouldReceive('parameters');

        $controller = new InspectionController($inspection, $project);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->store($request));
    }
}
