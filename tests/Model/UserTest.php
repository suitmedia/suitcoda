<?php

namespace SuitTests\Model;

use SuitTests\TestCase;
use Suitcoda\Model\User as Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testRouteKeyGetSlug()
    {
        $user = new Model;
        $user->slug = 'test';
        $this->assertEquals('test', $user->getRouteKey());
    }

    public function testCanStoreLoginTime()
    {
        $user = factory(Model::class)->create();
        $user->login();
        $time = \Carbon\Carbon::now()->format('H:i M j, Y');
        $this->assertEquals($time, $user->last_login_at);
    }

    public function testGetInitials()
    {
        $user = factory(Model::class)->make([
            'name' => 'Foo Bar Baz',
        ]);
        $this->assertEquals('FB', $user->getInitials());
    }

    public function testAdminMethodForAdmin()
    {
        $user = factory(Model::class)->make([
            'is_admin' => '1',
        ]);
        $this->assertEquals(true, $user->isAdmin());
        $this->assertEquals('Admin', $user->getAdminName());
    }

    public function testAdminMethodForUser()
    {
        $user = factory(Model::class)->make([
            'is_admin' => '0',
        ]);
        $this->assertEquals(false, $user->isAdmin());
        $this->assertEquals('User', $user->getAdminName());
    }
}
