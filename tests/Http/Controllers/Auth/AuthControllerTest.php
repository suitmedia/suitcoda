<?php

namespace SuitTests\Http\Controllers\Auth;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Controllers\Auth\AuthController;
use Suitcoda\Model\User as Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test Suitcoda\Http\Controllers\Auth\AuthController
 */
class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testVisitLoginPage()
    {
        $this->visit('login')
             ->see('Login');
        $this->assertInstanceOf('Illuminate\Http\Response', $this->response);
    }

    public function testPostLoginSuccess()
    {
        $input = ['username' => 'foo.bar', 'password' => 'asdfg', 'captcha' => 'asdf'];
        $user_faker = factory(Model::class)->create();
        $request = Mockery::mock('Suitcoda\Http\Requests\AuthRequest');
        $request->shouldReceive('only');
        \Auth::shouldReceive('attempt')->andReturn(true);

        $auth = new AuthController;
        $result = $auth->postLogin($request);

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals($this->app['url']->to('user'), $result->headers->get('Location'));
    }

    public function testPostLoginFailed()
    {
        $input = ['username' => 'foo.bar', 'password' => 'asdfg', 'captcha' => 'asdf'];
        $user_faker = factory(Model::class)->create();
        $request = Mockery::mock('Suitcoda\Http\Requests\AuthRequest');
        $request->shouldReceive('only');
        \Auth::shouldReceive('attempt')->andReturn(false);

        $auth = new AuthController;
        $result = $auth->postLogin($request);
        $error = $this->app['session.store']->get('errors')->get('username');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals($this->app['url']->to('login'), $result->headers->get('Location'));
        $this->assertContains('These credentials do not match our records.', $error);
    }

    public function testGetSuccessLogout()
    {
        $user_faker = factory(Model::class)->create();
        $this->be($user_faker);
        $this->visit('logout')
             ->seePageIs('/');
    }
}
