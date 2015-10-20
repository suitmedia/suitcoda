<?php

namespace SuitTests\Http\Requests;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Requests\UserEditRequest as Request;

class UserEditRequestTest extends TestCase
{
    public function testAuthorize()
    {
        $request = new Request;
        $this->assertEquals(true, $request->authorize());
    }

    public function testRulesKey()
    {
        $request = new Request;

        $result = $request->rules();

        $this->assertArrayHasKey('username', $request->rules());
        $this->assertArrayHasKey('email', $request->rules());
        $this->assertArrayHasKey('password', $request->rules());
        $this->assertArrayHasKey('name', $request->rules());
        $this->assertArrayHasKey('is_admin', $request->rules());
    }
}
