<?php

namespace SuitTests\Http\Middleware;

use Mockery;
use Suitcoda\Http\Middleware\RedirectIfAuthenticated;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Http\Middleware\RedirectIfAuthenticated
 */
class RedirectIfAuthenticatedTest extends TestCase
{

    /**
     * Test continue if not authenticate
     */
    public function testNotRedirectIfNotAuthenticated()
    {
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('check')->andReturn(false);

        $request = Mockery::mock('Illuminate\Http\Request');

        $authenticate = new RedirectIfAuthenticated($guard);

        $result = $authenticate->handle($request, function ($localRequest) {
            return 'success';
        });

        $this->assertEquals('success', $result);
    }

    /**
     * Test Redirect if authenticate
     */
    public function testRedirectIfAuthenticated()
    {
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('check')->andReturn(true);

        $request = Mockery::mock('Illuminate\Http\Request');

        $authenticate = new RedirectIfAuthenticated($guard);

        $result = $authenticate->handle($request, function ($request) {

        });

        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $result);
        $this->assertEquals(url('/'), $result->headers->get('Location'));
    }
}
