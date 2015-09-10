<?php

namespace SuitTests\Http\Requests;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Requests\AuthRequest as Request;

class AuthRequestTest extends TestCase
{
    public function testAuthorize()
    {
        $request = new Request;
        $this->assertEquals(true, $request->authorize());
    }

    public function testRulesKey()
    {
        $request = new Request;
        $this->assertArrayHasKey('username', $request->rules());
        $this->assertArrayHasKey('password', $request->rules());
        $this->assertArrayHasKey('captcha', $request->rules());
    }
}
