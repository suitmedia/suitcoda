<?php

namespace SuitTests\Http\Controllers;

use SuitTests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testHomeView()
    {
        $this->visit('/')
             ->see('Project List');
    }
}
