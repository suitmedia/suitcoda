<?php

namespace SuitTests\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
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
     * Test continue if success visiting home page
     *
     * @return void
     */
    public function testHomeView()
    {
        $userFaker = factory(User::class)->create();

        $this->actingAs($userFaker)
             ->visit('/')
             ->see('Project List');
    }

    /**
     * Test continue if success call index method
     *
     * @return void
     */
    public function testUnitIndex()
    {
        $userFaker = factory(User::class)->create();

        \Auth::shouldReceive('user')->andReturn($userFaker);
        $project = Mockery::mock(Project::class)->makePartial();
        $scope = Mockery::mock(Scope::class)->makePartial();
        $controller = new ProjectController($project, $scope);

        $this->assertInstanceOf('Illuminate\View\View', $controller->index());
    }

    /**
     * Test continue if success visiting create project page
     *
     * @return void
     */
    public function testIntegrationCreate()
    {
        $userFaker = factory(User::class)->create();

        $this->actingAs($userFaker)
             ->visit('project/create')
             ->see('Create New Project');
        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    /**
     * Test continue if success call create method
     *
     * @return void
     */
    public function testUnitCreate()
    {
        $project = Mockery::mock(Project::class);
        $scope = Mockery::mock(Scope::class)->makePartial();
        $controller = new ProjectController($project, $scope);

        $this->assertInstanceOf('Illuminate\View\View', $controller->create());
    }

    /**
     * Test continue if success submit project
     *
     * @return void
     */
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

    /**
     * Test continue if success call store method
     *
     * @return void
     */
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

    /**
     * Test continue if success call delete method
     *
     * @return void
     */
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

    /**
     * Test continue if get expected exception
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
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
        $controller->destroy(1);
    }

    /**
     * Test continue if success call search method
     *
     * @return void
     */
    public function testSearchProject()
    {
        $request = Mockery::mock(Request::class);
        $project = Mockery::mock(Project::class);
        $scope = Mockery::mock(Scope::class);

        $request->shouldReceive('input');
        $project->shouldReceive('search->get');

        $controller = new ProjectController($project, $scope);
        
        $this->assertInstanceOf('Illuminate\View\View', $controller->search($request));
    }
}
