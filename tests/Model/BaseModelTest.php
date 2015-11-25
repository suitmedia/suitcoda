<?php

namespace SuitTests\Model;

use Suitcoda\Model\User;
use SuitTests\TestCase;

class BaseModelTest extends TestCase
{
    /**
     * Test get key of slug
     *
     * @return void
     */
    public function testGetKeyReturnsValueOfSlug()
    {
        $user = new User;
        $user->slug = 'test';
        $this->assertEquals('test', $user->getUrlKey());
        $this->assertEquals('slug', $user->getUrlKeyName());
    }
}
