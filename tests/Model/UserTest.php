<?php

namespace SuitTests\Model;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\User;
use SuitTests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get route key by slug
     *
     * @return void
     */
    public function testRouteKeyGetSlug()
    {
        $user = new User;
        $user->slug = 'test';
        $this->assertEquals('test', $user->getRouteKey());
    }

    /**
     * Test get last_login_at attribute with custom format time
     *
     * @return void
     */
    public function testCanStoreLoginTime()
    {
        $user = factory(User::class)->create();
        $user->login();
        $time = \Carbon\Carbon::now()->format('H:i M j, Y');
        $this->assertEquals($time, $user->last_login_at);
    }

    /**
     * Test get initials
     *
     * @return void
     */
    public function testGetInitials()
    {
        $user = factory(User::class)->make([
            'name' => 'Foo Bar Baz',
        ]);
        $this->assertEquals('FB', $user->getInitials());
    }

    /**
     * Test get role name for admin
     *
     * @return void
     */
    public function testAdminMethodForAdmin()
    {
        $user = factory(User::class)->make([
            'is_admin' => '1',
        ]);
        $this->assertEquals(true, $user->isAdmin());
        $this->assertEquals('Admin', $user->getAdminName());
    }

    /**
     * Test get role name for user
     *
     * @return void
     */
    public function testAdminMethodForUser()
    {
        $user = factory(User::class)->make([
            'is_admin' => '0',
        ]);
        $this->assertEquals(false, $user->isAdmin());
        $this->assertEquals('User', $user->getAdminName());
    }
}
