<?php

namespace SuitTests\Model;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Group as Model;

class GroupTest extends TestCase
{
    public function testGetRouteKey()
    {
        $roles = new Model;
        $roles->slug = 'test';

        $this->assertEquals('test', $roles->getRouteKey());
    }
}
