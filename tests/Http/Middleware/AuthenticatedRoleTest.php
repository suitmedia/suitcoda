<?php

namespace SuitTests\Http\Middleware;

use Mockery;
use Suitcoda\Http\Middleware\AuthenticatedRole;
use Suitcoda\Model\User;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Http\Middleware\RedirectIfAuthenticated
 */
class AuthenticatedRoleTest extends TestCase
{

    /**
     * Test call Unauthorized if admin is user
     */
    public function testRedirectTo401()
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('isAdmin')->andReturn(false);
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('user')->andReturn($user);

        $request = Mockery::mock('Illuminate\Http\Request');

        $authenticate = new AuthenticatedRole($guard);

        $result = $authenticate->handle($request, function ($localRequest) {
        });

        $this->assertInstanceOf('Illuminate\Http\Response', $result);
        $this->assertEquals(401, $result->getStatusCode());
    }

    /**
     * Test pass if user is admin
     */
    public function testPassIfUserIsAdmin()
    {
        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('isAdmin')->andReturn(true);
        $guard = Mockery::mock('Illuminate\Auth\Guard');
        $guard->shouldReceive('user')->andReturn($user);

        $request = Mockery::mock('Illuminate\Http\Request');

        $authenticate = new AuthenticatedRole($guard);

        $result = $authenticate->handle($request, function ($localRequest) {
            return 'success';
        });

        $this->assertEquals('success', $result);
    }
}
