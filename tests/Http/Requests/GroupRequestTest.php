<?php

namespace SuitTests\Http\Requests;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Http\Requests\GroupRequest as Request;

class GroupRequestTest extends TestCase
{
    public function testAuthorize()
    {
        $request = new Request;
        $this->assertEquals(true, $request->authorize());
    }

    public function testRulesKey()
    {
        $request = new Request;
        $this->assertArrayHasKey('name', $request->rules());
        $this->assertArrayHasKey('slug', $request->rules());
    }
}
