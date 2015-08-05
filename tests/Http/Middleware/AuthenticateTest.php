<?php

namespace SuitTests\Http\Middleware;

use Mockery;
use Suitcoda\Http\Middleware\Authenticate;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Http\Middleware\Authenticate
 */
class AuthenticateTest extends TestCase
{

    /**
     * Test continue if authenticate
     */
    public function testNotRedirectIfAuthenticate()
    {
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('guest')->andReturn(false);

        $request = Mockery::mock('Illuminate\Http\Request');

        $authenticate = new Authenticate($guard);

        $result = $authenticate->handle($request, function ($localRequest) {
            return 'success';
        });

        $this->assertEquals('success', $result);
    }

    /**
     * Test Redirect if guest and return response if request is ajax
     */
    public function testRedirectIfGuest()
    {
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('guest')->andReturn(true);

        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('ajax')->times(2)->andReturn(false, true);

        $authenticate = new Authenticate($guard);

        $result = $authenticate->handle($request, function ($request) {
            //
        });

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals(url('auth/login'), $result->headers->get('Location'));

        $result = $authenticate->handle($request, function ($request) {
            //
        });

        $this->assertInstanceOf('Illuminate\Http\Response', $result);
        $this->assertEquals(401, $result->getStatusCode());
    }
}
