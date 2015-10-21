<?php

namespace SuitTests\Model;

use SuitTests\TestCase;
use Suitcoda\Model\Project as Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function testRouteKeyGetSlug()
    {
        $project = new Model;
        $project->slug = 'test';
        $this->assertEquals('test', $project->getRouteKey());
    }

    public function testMainUrlFormatBeforeSet()
    {
        $project = new Model;
        $this->assertEquals('http://', $project->main_url);
    }

    public function testMainUrlFormatAfterSet()
    {
        $project = new Model;
        $project->main_url = 'http://example.com';
        $this->assertEquals('http://example.com', $project->main_url);
    }

    public function testUpdatedAtFormat()
    {
        $project = new Model;
        $time = \Carbon\Carbon::now();
        $project->updated_at = $time;
        $this->assertEquals($time->format('H:i M j, Y'), $project->updated_at);
    }
}
