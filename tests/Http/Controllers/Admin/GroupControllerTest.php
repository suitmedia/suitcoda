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
        
        $model = Mockery::mock('Suitcoda\Model\Group[all]');
        $model->shouldReceive('all')->once();
        $group = new GroupController($model);

        $this->assertInstanceOf('Illuminate\View\View', $group->index());
        $this->assertViewHas('models');
    }

    public function testCreateGetSuccessResponse()
    {
        $this->visit('group/create')
             ->see('Group Create');
        $this->assertResponseOk();
        
        $model = Mockery::mock('Suitcoda\Model\Group');
        $group = new GroupController($model);

        $this->assertInstanceOf('Illuminate\View\View', $group->create());
        $this->assertViewHas('model');
    }

    public function testStoreSuccessResponse()
    {
        $input = ['name' => 'foo', 'slug' => 'foo'];
        $permissions = ['test', 'test2'];

        $this->visit('group/create')
             ->type('Foo bar', 'name')
             ->press('Submit Button')
             ->seePageIs('group');
        $this->assertResponseOk();

        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest[except, get]');
        $request->shouldReceive('except')->once()->with('permissions')->andReturn($input);
        $request->shouldReceive('get')->andReturn($permissions);

        $model = Mockery::mock('Suitcoda\Model\Group[newInstance, save]');
        $model->shouldReceive('newInstance')->once()->andReturn($model);
        $model->shouldReceive('save')->andReturn(true);

        $group = new GroupController($model);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $group->store($request));
    }

    public function testEditSuccessResponse()
    {
        $this->visit('group/'. $this->roles->slug . '/edit')
             ->see('Group Edit');
        $this->assertResponseOk();

        $model = Mockery::mock('Suitcoda\Model\Group');
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($model);

        $group = new GroupController($model);

        $this->assertInstanceOf('Illuminate\View\View', $group->edit(1));
    }

    public function testUpdateSuccessResponse()
    {
        $input = ['name' => 'Bar', 'slug' => 'bar'];
        $permissions = ['test', 'test2'];

        $this->visit('group/'. $this->roles->slug . '/edit')
             ->type('Foo bar', 'name')
             ->press('Submit Button')
             ->seePageIs('group');
        $this->assertResponseOk();

        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest[except, get]');
        $request->shouldReceive('except')->once()->with('permissions')->andReturn($input);
        $request->shouldReceive('get')->andReturn($permissions);


        $model = Mockery::mock('Suitcoda\Model\Group[save]');
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($model);
        $model->shouldReceive('save')->andReturn(true);
        
        $group = new GroupController($model);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $group->update($request, 1));
    }

    public function testDeleteSuccessResponse()
    {
        $this->visit('group')
             ->press('Delete')
             ->seePageIs('group');
        $this->assertResponseOk();

        $model = Mockery::mock('Suitcoda\Model\Group');
        $group = new GroupController($model);

        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($model);
        $model->shouldReceive('delete')->once()->andReturn(true);

        $result =  $group->destroy(1);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testNotFoundSlug()
    {
        $model = Mockery::mock('Suitcoda\Model\Group');
        $group = new GroupController($model);
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn(null);
        $result =  $group->edit(1);
    }
}
