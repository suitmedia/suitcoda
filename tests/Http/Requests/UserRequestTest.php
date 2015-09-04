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
}
