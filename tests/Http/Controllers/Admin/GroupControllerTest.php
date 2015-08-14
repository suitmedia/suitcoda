<?php

namespace SuitTests\Http\Controllers\Admin;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\Admin\GroupController;
use Suitcoda\Model\Group as Model;

class GroupControllerTest extends TestCase
{
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = Mockery::mock('Suitcoda\Model\Group');
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testIndexGetSuccessResponse()
    {
        $this->route('GET', 'group.index');
        $this->assertResponseOk();
    }

    public function testIndexSuccessReturn()
    {
        $this->model->shouldReceive('all')->once();

        $group = new GroupController($this->model);

        $result = $group->index();
        $this->assertInstanceOf('Illuminate\View\View', $result);
    }

    public function testCreateGetSuccessResponse()
    {
        $this->route('GET', 'group.create');
        $this->assertResponseOk();
    }

    public function testCreateGetSuccessReturn()
    {
        $group = new GroupController($this->model);

        $result = $group->create();
        $this->assertInstanceOf('Illuminate\View\View', $result);
    }

    public function testStoreSuccessReturn()
    {
        $input = array('name' => 'asd', 'slug' => 'asd');
        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest');
        $request->shouldReceive('all')->once()->andReturn($input);

        $this->model->shouldReceive('newInstance')->once()->andReturn($this->model);
        $this->model->shouldReceive('fill')->once()->with($input);
        $this->model->shouldReceive('save')->once()->andReturn(true);
        $group = new GroupController($this->model);

        $result = $group->store($request);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    public function testStoreFailsResponse()
    {
        $response = $this->route('POST', 'group.store');
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testEditSuccessReturn()
    {
        $group = new GroupController($this->model);
        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        $result =  $group->edit(1);

        $this->assertInstanceOf('Illuminate\View\View', $result);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testEditExpectNotFoundHttpException()
    {
        $group = new GroupController($this->model);
        $result =  $group->edit(1);
    }

    public function testUpdateSuccessReturn()
    {
        $input = array('name' => '2', 'slug' => '2');

        $request = Mockery::mock('Suitcoda\Http\Requests\GroupRequest');
        $request->shouldReceive('all')->once()->andReturn($input);

        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        
        $this->model->shouldReceive('fill')->once()->with($input);
        $this->model->shouldReceive('save');
        
        $group = new GroupController($this->model);

        $result = $group->update($request, 1);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }

    public function testDeleteSuccessReturn()
    {
        $group = new GroupController($this->model);

        \Sentinel::shouldReceive('findRoleBySlug')->with(1)->andReturn($this->model);
        $this->model->shouldReceive('delete')->once()->andReturn(true);

        $result =  $group->destroy(1);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
    }
}
