<?php

namespace SuitTests\Http\Controllers;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\UserController;
use Suitcoda\Model\User as Model;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testIntegrationIndex()
    {
        $userFaker = factory(Model::class)->create();
        $this->visit('user')
             ->see($userFaker->name);
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'name' => $userFaker->name,
            'email' => $userFaker->email,
        ]);
        $this->assertViewHas('models');
    }

    public function testUnitIndex()
    {
        $model = Mockery::mock('Suitcoda\Model\User[all]');
        $model->shouldReceive('all')->once();
        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->index());
    }

    public function testIntegrationCreate()
    {
        $this->visit('user/create')
             ->see('Create New Account');
        $this->assertResponseOk();
        $this->assertViewHas('model');
    }

    public function testUnitCreate()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->create());
    }

    public function testIntegrationStore()
    {
        $this->visit('user/create')
             ->type('Foo bar', 'name')
             ->type('Foobar', 'username')
             ->type('foo@bar.com', 'email')
             ->type('foobar123', 'password')
             ->type('foobar123', 'password_confirmation')
             ->press('Save')
             ->seePageIs('user');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => 'Foobar',
            'email' => 'foo@bar.com'
        ]);
        $this->assertViewHas('models');
    }

    public function testUnitStore()
    {
        $input = ['username' => 'foo.bar', 'email' => 'foo@bar.com', 'password' => 'asdfg', 'name' => 'foo bar'];

        $request = Mockery::mock('Suitcoda\Http\Requests\UserCreateRequest[all]');
        $request->shouldReceive('all')->once()->andReturn($input);

        $model = Mockery::mock('Suitcoda\Model\user[newInstance, save]');
        $model->shouldReceive('newInstance')->once()->andReturn($model);
        $model->shouldReceive('save')->once();

        $user = new userController($model);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->store($request));
    }

    public function testIntegrationEdit()
    {
        $userFaker = factory(Model::class)->create();
        $this->visit('user/'. $userFaker->slug . '/edit')
             ->see('Edit Account');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => $userFaker->username,
            'email' => $userFaker->email
        ]);
        $this->assertViewHas('model');
    }

    public function testUnitEdit()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);
        $user = new UserController($model);
        $this->assertInstanceOf('Illuminate\View\View', $user->edit(1));
    }

    public function testIntegrationUpdate()
    {
        $userFaker = factory(Model::class)->create();
        $this->visit('user/'. $userFaker->slug . '/edit')
             ->type('Foo bar', 'name')
             ->type('Foobar', 'username')
             ->type('foo@bar.com', 'email')
             ->type('foobar123', 'password')
             ->type('foobar123', 'password_confirmation')
             ->press('Save')
             ->seePageIs('user');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => 'Foobar',
            'email' => 'foo@bar.com'
        ]);
        $this->assertViewHas('models');
    }

    public function testUnitUpdate()
    {
        $input = [
            'username' => 'foo.bar',
            'email' => 'foo@bar.com',
            'password' => 'asdfg',
            'password_confirmation' => 'asdfg',
            'name' => 'foo bar'
        ];
        $request = Mockery::mock('Suitcoda\Http\Requests\UserEditRequest[all]');
        $request->shouldReceive('all')->once()->andReturn($input);

        $model = Mockery::mock('Suitcoda\Model\User[update]');
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn($model);
        $model->shouldReceive('update')->once();

        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->update($request, 1));
    }

    public function testUnitDelete()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);
        
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);
        $model->shouldReceive('delete')->once()->andReturn(true);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->destroy(1));
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testUserNotFound()
    {
        $model = Mockery::mock('Suitcoda\Model\user');
        $group = new UserController($model);
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn(null);
        $result =  $group->destroy(1);
    }
}
