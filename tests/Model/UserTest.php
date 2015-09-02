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
        $time = \Carbon\Carbon::now();
        $this->assertEquals($time, $user->last_login_at);
    }
}
