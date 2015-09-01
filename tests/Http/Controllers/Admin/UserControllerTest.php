<?php

namespace SuitTests\Http\Controllers\Admin;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\Admin\UserController;
use Suitcoda\Model\User as Model;
use Suitcoda\Model\Group as Roles;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

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
        $user_faker = factory(Model::class)->create();
        $this->visit('user')
             ->see($user_faker->username);
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => $user_faker->username,
            'email' => $user_faker->email,
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
             ->see('User Create');
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
             ->type('Foobar', 'username')
             ->type('foo@bar.com', 'email')
             ->type(bcrypt(str_random(5)), 'password')
             ->press('Submit Button')
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
        $input = ['username' => 'foo.bar', 'email' => 'foo@bar.com', 'password' => 'asdfg', 'roles' => 'admin'];

        $request = Mockery::mock('Suitcoda\Http\Requests\userRequest[except]');
        $request->shouldReceive('except')->once()->andReturn($input);

        $model = Mockery::mock('Suitcoda\Model\user[newInstance, save]');
        $model->shouldReceive('newInstance')->once()->andReturn($model);
        $model->shouldReceive('save')->andReturn(true);

        $user = new userController($model);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->store($request));
    }

    public function testIntegrationEdit()
    {
        $user_faker = factory(Model::class)->create();
        $this->visit('user/'. $user_faker->id . '/edit')
             ->see('User Edit');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => $user_faker->username,
            'email' => $user_faker->email
        ]);
        $this->assertViewHas('model');
    }

    public function testUnitEdit()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        \Sentinel::shouldReceive('findById')->with(1)->andReturn($model);

        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->edit(1));
    }

    public function testIntegrationUpdate()
    {
        $user_faker = factory(Model::class)->create();

        $this->visit('user/'. $user_faker->id . '/edit')
             ->type('Foo.bar', 'username')
             ->type('foo@bar.com', 'email')
             ->type(bcrypt('asdfg'), 'password')
             ->press('Submit Button')
             ->seePageIs('user');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'id' => $user_faker->id,
            'username' => 'Foo.bar',
            'email' => 'foo@bar.com'
        ]);
        $this->assertViewHas('models');
    }

    public function testUnitUpdate()
    {
        $group = factory(Roles::class)->create();
        $input = ['username' => 'foo.bar', 'email' => 'foo@bar.com', 'password' => 'asdfg', 'roles' => 'admin'];
        $request = Mockery::mock('Suitcoda\Http\Requests\UserRequest[except, get]');
        $request->shouldReceive('except')->andReturn($input);
        $request->shouldReceive('get')->andReturn($group->name);

        $relations = Mockery::mock('Illuminate\Database\Eloquent\Relations\BelongsToMany');
        $relations->shouldReceive('detach');
        $relations->shouldReceive('first')->andReturn($group);
        $relations->shouldReceive('attach');

        $model = Mockery::mock('Suitcoda\Model\User[roles, save]');
        $model->shouldReceive('roles')->andReturn($relations);
        $model->shouldReceive('save')->andReturn(true);


        \Sentinel::shouldReceive('findById')->with(1)->once()->andReturn($model);
        \Sentinel::shouldReceive('findRoleByName')->with($group->name)->andReturn($group->name);

        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->update($request, 1));
    }

    public function testIntegrationDelete()
    {
        $user_faker = factory(Model::class)->create();
        $this->visit('user')
             ->press('Delete')
             ->seePageIs('user');
        $this->assertResponseOk();
        $this->notSeeInDatabase('users', [
            'username' => $user_faker->username,
            'email' => $user_faker->email,
        ]);
    }

    public function testUnitDelete()
    {
        $group = factory(Roles::class)->create();
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);

        $relations = Mockery::mock('Illuminate\Database\Eloquent\Relations\BelongsToMany');
        $relations->shouldReceive('detach');
        $relations->shouldReceive('first')->andReturn($group);

        \Sentinel::shouldReceive('findById')->with(1)->andReturn($model);
        \Sentinel::shouldReceive('findRoleByName')->with($group->name)->andReturn($group->name);
        
        $model->shouldReceive('delete')->once()->andReturn(true);
        $model->shouldReceive('roles')->andReturn($relations);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->destroy(1));
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     */
    public function testNotFoundId()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);
        \Sentinel::shouldReceive('findById')->with(1)->andReturn(null);
        $result =  $user->edit(1);
    }
}
