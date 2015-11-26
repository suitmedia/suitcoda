<?php

namespace SuitTests\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Suitcoda\Http\Controllers\UserController;
use Suitcoda\Model\User as Model;
use SuitTests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

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
     * Test continue if success visiting manage user
     *
     * @return void
     */
    public function testIntegrationIndex()
    {
        $userFaker = factory(Model::class)->create([
            'name' => 'Foo Bar'
        ]);
        $this->visit('user')
             ->see($userFaker->name);
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'name' => $userFaker->name,
            'email' => $userFaker->email,
        ]);
        $this->assertViewHas('models');
    }

    /**
     * Test continue if success call index method
     *
     * @return void
     */
    public function testUnitIndex()
    {
        $model = Mockery::mock('Suitcoda\Model\User[all]');
        $model->shouldReceive('allAccount')->once();
        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->index());
    }

    /**
     * Test continue if success visiting create user page
     *
     * @return void
     */
    public function testIntegrationCreate()
    {
        $this->visit('user/create')
             ->see('Create New Account');
        $this->assertResponseOk();
        $this->assertViewHas('model');
    }

    /**
     * Test continue if success call create method
     *
     * @return void
     */
    public function testUnitCreate()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\View\View', $user->create());
    }

    /**
     * Test continue if success submit new user
     *
     * @return void
     */
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

    /**
     * Test continue if success call store method
     *
     * @return void
     */
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

    /**
     * Test continue if success visiting edit user page
     *
     * @return void
     */
    public function testIntegrationEdit()
    {
        $userFaker = factory(Model::class)->create();
        $this->visit('user/' . $userFaker->slug . '/edit')
             ->see('Edit Account');
        $this->assertResponseOk();
        $this->seeInDatabase('users', [
            'username' => $userFaker->username,
            'email' => $userFaker->email
        ]);
        $this->assertViewHas('model');
    }

    /**
     * Test continue if success call edit method
     *
     * @return void
     */
    public function testUnitEdit()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);
        $user = new UserController($model);
        $this->assertInstanceOf('Illuminate\View\View', $user->edit(1));
    }

    /**
     * Test continue if success submit update user
     *
     * @return void
     */
    public function testIntegrationUpdate()
    {
        $userFaker = factory(Model::class)->create();
        $this->visit('user/' . $userFaker->slug . '/edit')
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

    /**
     * Test continue if success call update method
     *
     * @return void
     */
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

        $model = Mockery::mock('Suitcoda\Model\User[save]');
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn($model);
        $model->shouldReceive('save')->once();

        $user = new UserController($model);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->update($request, 1));
    }

    /**
     * Test continue if success call delete method
     *
     * @return void
     */
    public function testUnitDelete()
    {
        $model = Mockery::mock('Suitcoda\Model\User');
        $user = new UserController($model);
        
        $model->shouldReceive('findOrFailByUrlKey')->andReturn($model);
        $model->shouldReceive('delete')->once()->andReturn(true);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $user->destroy(1));
    }

    /**
     * Test continue if get expected exception
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    public function testUserNotFound()
    {
        $model = Mockery::mock('Suitcoda\Model\user');
        $group = new UserController($model);
        $model->shouldReceive('findOrFailByUrlKey')->once()->andReturn(null);
        $group->destroy(1);
    }
}
