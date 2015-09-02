<?php

namespace SuitTests\Http\Requests;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Requests\UserRequest as Request;

class UserRequestTest extends TestCase
{
    public function testAuthorize()
    {
        $request = new Request;
        $this->assertEquals(true, $request->authorize());
    }

    public function testRulesKey()
    {
        // $request = new Request;
        // $request->all();
        // $this->assertArrayHasKey('username', $request->rules());
        // $this->assertArrayHasKey('email', $request->rules());
        // $this->assertArrayHasKey('password', $request->rules());
        // $this->assertArrayHasKey('name', $request->rules());
        // $this->assertArrayHasKey('slug', $request->rules());
        // $this->assertArrayHasKey('date_of_birth', $request->rules());
        // $this->assertArrayHasKey('is_admin', $request->rules());
        // $this->assertArrayHasKey('is_active', $request->rules());
    }
}
