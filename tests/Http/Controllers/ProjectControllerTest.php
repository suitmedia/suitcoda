<?php

namespace SuitTests\Http\Controllers;

use SuitTests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Project;
use Suitcoda\Model\User;
use Suitcoda\Http\Controllers\ProjectController;
use Suitcoda\Http\Requests\ProjectRequest;

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
        $model = Mockery::mock(Project::class)->makePartial();
        $user = new ProjectController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->index());
    }

    public function testIntegrationCreate()
    {
        $userFaker = factory(User::class)->create();

        $this->actingAs($userFaker)
             ->visit('project/create')
             ->see('Create New Project');
        $this->assertResponseOk();
        $this->assertViewHas('model');
    }

    public function testUnitCreate()
    {
        $model = Mockery::mock(Project::class);
        $user = new ProjectController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->create());
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
        $this->assertViewHas('models');
    }

    public function testUnitStore()
    {
        $input = ['name' => 'Foo bar', 'main_url' => 'http://foobar.com'];

        $request = Mockery::mock(ProjectRequest::class)->makePartial();
        $request->shouldReceive('all')->once()->andReturn($input);

        $model = Mockery::mock(Project::class)->makePartial();
        $model->shouldReceive('newInstance')->once()->andReturn($model);
        $model->shouldReceive('save')->once();

        $user = new ProjectController($model);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->store($request));
    }

    public function testUnitDelete()
    {
        $model = Mockery::mock(Project::class);
        $project = new ProjectController($model);
        
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);
        $model->shouldReceive('delete')->once()->andReturn(true);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $project->destroy(1));
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testProjectNotFound()
    {
        $model = Mockery::mock(Project::class);
        $group = new ProjectController($model);
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn(null);
        $result =  $group->destroy(1);
    }
}
