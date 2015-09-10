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
             ->type('foobar123', 'password')
             ->type('foobar123', 'password_confirmation')
             ->type('Foo bar', 'name')
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
        $input = ['username' => 'foo.bar', 'email' => 'foo@bar.com', 'password' => 'asdfg', 'name' => 'foo bar'];

        $request = Mockery::mock('Suitcoda\Http\Requests\userRequest[all]');
        $request->shouldReceive('all')->once()->andReturn($input);

        $model = Mockery::mock('Suitcoda\Model\user[newInstance, save]');
        $model->shouldReceive('newInstance')->once()->andReturn($model);
        $model->shouldReceive('save')->once();

        $user = new userController($model);
        
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->store($request));
    }

    public function testIntegrationEdit()
    {
        $user_faker = factory(Model::class)->create();
        $this->visit('user/'. $user_faker->slug . '/edit')
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
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);

        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->edit(1));
    }

    public function testIntegrationUpdate()
    {
        $user_faker = factory(Model::class)->create();

        $this->visit('user/'. $user_faker->slug . '/edit')
             ->type('Foo.bar', 'username')
             ->type('foo@bar.com', 'email')
             ->type('foobar123', 'password')
             ->type('foobar123', 'password_confirmation')
             ->type('Foo bar', 'name')
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
        $input = ['username' => 'foo.bar', 'email' => 'foo@bar.com', 'password' => 'asdfg', 'roles' => 'admin'];
        $request = Mockery::mock('Suitcoda\Http\Requests\UserRequest[all]');
        $request->shouldReceive('all')->andReturn($input);

        $model = Mockery::mock('Suitcoda\Model\User[update]');
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn($model);
        $model->shouldReceive('update')->once();

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
        $result =  $group->edit(1);
    }
}
