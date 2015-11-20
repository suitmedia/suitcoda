<?php

namespace SuitTests\Model;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Project;
use Suitcoda\Model\User;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function testRouteKeyGetSlug()
    {
        $project = new Project;
        $project->slug = 'test';
        $this->assertEquals('test', $project->getRouteKey());
    }

    public function testMainUrlFormatBeforeSet()
    {
        $project = new Project;
        $this->assertEquals('http://', $project->main_url);
    }

    public function testMainUrlFormatAfterSet()
    {
        $project = new Project;
        $project->main_url = 'http://example.com';
        $this->assertEquals('http://example.com', $project->main_url);
    }

    public function testUpdatedAtFormat()
    {
        $project = new Project;
        $time = \Carbon\Carbon::now();
        $project->updated_at = $time;
        $this->assertEquals($time->format('H:i M j, Y'), $project->updated_at);
    }

    public function testScopeFindBySlug()
    {
        $userFaker = factory(User::class)->create(['name' => 'test']);
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);

        $project = new Project;

        $this->assertInstanceOf(Project::class, $project->findBySlug('example'));
    }
}
