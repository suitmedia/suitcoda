<?php

namespace SuitTests\Http\Controllers\Admin;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\Admin\GroupController;
use Suitcoda\Model\Group as Model;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $model;

    protected $roles;

    public function setUp()
    {
        parent::setUp();
        $this->model = Mockery::mock('Suitcoda\Model\Group');
        $this->roles = factory(Model::class)->create();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testIndexGetSuccessResponse()
    {
        $this->visit('group')
             ->see($this->roles->name);
        $this->assertResponseOk();
    
        $this->model->shouldReceive('all')->once();
        $group = new GroupController($this->model);

        $result = $group->index();
        $this->assertInstanceOf('Illuminate\View\View', $result);
        $this->assertViewHas('models');
    }

    public function testCreateGetSuccessResponse()
    {
        $this->visit('group/create')
             ->see('Group Create');
        $this->assertResponseOk();
    
        $group = new GroupController($this->model);

        $result = $group->create();
        $this->assertInstanceOf('Illuminate\View\View', $result);
        $this->assertViewHas('model');
    }

    public function testStoreSuccessResponse()
    {
        $input = ['name' => 'foo', 'slug' => 'foo'];

        $this->visit('group/create')
             ->type('Foo bar', 'name')
             ->press('Submit Button')
             ->seePageIs('group');
        $this->assertResponseOk();

        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest');
        $request->shouldReceive('all')->once()->andReturn($input);

        $this->model->shouldReceive('newInstance')->once()->andReturn($this->model);
        $this->model->shouldReceive('fill')->once()->with($input);
        $this->model->shouldReceive('save')->once()->andReturn(true);
        $group = new GroupController($this->model);

        $result = $group->store($request);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    public function testEditSuccessResponse()
    {
        $this->visit('group/'. $this->roles->slug . '/edit')
             ->see('Group Edit');
        $this->assertResponseOk();

        $group = new GroupController($this->model);
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        $result =  $group->edit(1);

        $this->assertInstanceOf('Illuminate\View\View', $result);
    }

    public function testUpdateSuccessResponse()
    {
        $input = ['name' => 'Bar', 'slug' => 'bar'];
        $this->visit('group/'. $this->roles->slug . '/edit')
             ->type('Foo bar', 'name')
             ->press('Submit Button')
             ->seePageIs('group');
        $this->assertResponseOk();

        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest');
        $request->shouldReceive('all')->once()->andReturn($input);

        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        
        $this->model->shouldReceive('fill')->once()->with($input);
        $this->model->shouldReceive('save');
        
        $group = new GroupController($this->model);

        $result = $group->update($request, 1);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    public function testDeleteSuccessResponse()
    {
        $this->visit('group')
             ->press('Delete')
             ->seePageIs('group');
        $this->assertResponseOk();

        $group = new GroupController($this->model);

        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        $this->model->shouldReceive('delete')->once()->andReturn(true);

        $result =  $group->destroy(1);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testNotFoundSlug()
    {
        $group = new GroupController($this->model);
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn(null);
        $result =  $group->edit(1);
    }
}
