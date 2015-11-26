<?php

namespace SuitTests\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Http\Controllers\Auth\AuthController;
use Suitcoda\Model\User;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Http\Controllers\Auth\AuthController
 */
class AuthControllerTest extends TestCase
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
     * Test continue if success visiting login page
     *
     * @return void
     */
    public function testVisitLoginPage()
    {
        $this->visit('login')
             ->see('Login');
        $this->assertInstanceOf('Illuminate\Http\Response', $this->response);
    }

    /**
     * Test continue if success login
     *
     * @return void
     */
    public function testPostLoginSuccess()
    {
        $request = Mockery::mock('Suitcoda\Http\Requests\AuthRequest');
        $user = Mockery::mock(User::class);
        
        $request->shouldReceive('only');
        $request->shouldReceive('has');
        $user->shouldReceive('login');
        \Auth::shouldReceive('attempt')->andReturn(true);
        \Auth::shouldReceive('user')->andReturn($user);

        $auth = new AuthController;
        $result = $auth->postLogin($request);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals($this->app['url']->to('/'), $result->headers->get('Location'));
    }

    /**
     * Test continue if failed login
     *
     * @return void
     */
    public function testPostLoginFailed()
    {
        $request = Mockery::mock('Suitcoda\Http\Requests\AuthRequest');
        $request->shouldReceive('only');
        $request->shouldReceive('has');
        \Auth::shouldReceive('attempt')->andReturn(false);

        $auth = new AuthController;
        $result = $auth->postLogin($request);
        $error = $this->app['session.store']->get('errors')->get('username');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals($this->app['url']->to('login'), $result->headers->get('Location'));
        $this->assertContains('These credentials do not match our records.', $error);
    }

    /**
     * Test continue if success get login page
     *
     * @return void
     */
    public function testGetSuccessLogout()
    {
        $userFaker = factory(User::class)->create();
        $this->be($userFaker);
        $this->visit('/')
             ->click('Logout')
             ->seePageIs('/login');
    }
}
