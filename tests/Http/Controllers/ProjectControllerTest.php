<?php

namespace SuitTests\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\ProjectController;
use Suitcoda\Http\Requests\ProjectRequest;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\User;

class ProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testHomeView()
    {
        $userFaker = factory(User::class)->create();
        $this->actingAs($userFaker)
             ->visit('/')
             ->see('Project List');
    }

    public function testUnitIndex()
    {
        $userFaker = factory(User::class)->create();
        \Auth::shouldReceive('user')->andReturn($userFaker);
        $project = Mockery::mock(Project::class)->makePartial();
        $scope = Mockery::mock(Scope::class)->makePartial();
        $controller = new ProjectController($project, $scope);

        $this->assertInstanceOf('Illuminate\View\View', $controller->index());
    }

    public function testIntegrationCreate()
    {
        $userFaker = factory(User::class)->create();

        $this->actingAs($userFaker)
             ->visit('project/create')
             ->see('Create New Project');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    public function testUnitCreate()
    {
        $project = Mockery::mock(Project::class);
        $scope = Mockery::mock(Scope::class)->makePartial();
        $controller = new ProjectController($project, $scope);

        $this->assertInstanceOf('Illuminate\View\View', $controller->create());
    }

    public function testIntegrationStore()
    {
        $userFaker = factory(User::class)->create();

        $this->actingAs($userFaker)
             ->visit('project/create')
             ->type('Foo bar', 'name')
             ->type('http://foobar.com', 'main_url')
             ->press('Save')
             ->seePageIs('/');
        $this->assertResponseOk();
        $this->seeInDatabase('projects', [
            'name' => 'Foo bar',
            'main_url' => 'http://foobar.com'
        ]);
        $this->assertViewHas('projects');
    }

    public function testUnitStore()
    {
        $input = ['name' => 'Foo bar', 'main_url' => 'http://foobar.com'];

        $request = Mockery::mock(ProjectRequest::class)->makePartial();
        $request->shouldReceive('all')->once()->andReturn($input);

        $project = Mockery::mock(Project::class)->makePartial();
        $scope = Mockery::mock(Scope::class)->makePartial();
        $project->shouldReceive('newInstance')->once()->andReturn($project);
        $project->shouldReceive('save')->once();

        $controller = new ProjectController($project, $scope);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->store($request));
    }

    public function testUnitDelete()
    {
        $project = Mockery::mock(Project::class);
        $scope = Mockery::mock(Scope::class)->makePartial();
        $user = Mockery::mock(User::class);
        $controller = new ProjectController($project, $scope);
        
        \Auth::shouldReceive('user')->andReturn($user);
        $user->shouldReceive('projects')->andReturn($project);
        $project->shouldReceive('findOrFailByUrlKey')->andReturn($project);
        $project->shouldReceive('delete')->once()->andReturn(true);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $controller->destroy(1));
    }

    public function testIntegrationGraph()
    {
        $userFaker = factory(User::class)->create();
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        $inspectionFaker = factory(Inspection::class)->make();
        $projectFaker->inspections()->save($inspectionFaker);

        $this->actingAs($userFaker)
             ->visit('project/' . $projectFaker->slug . '/graph')
             ->seeJson(['title' => 'Example']);
        $this->assertResponseOk();
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testProjectNotFound()
    {
        $project = Mockery::mock(Project::class);
        $scope = Mockery::mock(Scope::class)->makePartial();
        $user = Mockery::mock(User::class);
        $controller = new ProjectController($project, $scope);
        
        \Auth::shouldReceive('user')->andReturn($user);
        $user->shouldReceive('projects')->andReturn($project);
        $project->shouldReceive('findOrFailByUrlKey')->andReturn(null);
        $result =  $controller->destroy(1);
    }
}
