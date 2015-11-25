<?php

namespace SuitTests\Model;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Project;
use Suitcoda\Model\User;
use SuitTests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test get route key by slug
     *
     * @return void
     */
    public function testRouteKeyGetSlug()
    {
        $project = new Project;
        $project->slug = 'test';
        $this->assertEquals('test', $project->getRouteKey());
    }

    /**
     * Test get main url before set the value
     *
     * @return void
     */
    public function testMainUrlFormatBeforeSet()
    {
        $project = new Project;
        $this->assertEquals('http://', $project->main_url);
    }

    /**
     * Test get main url after set the value
     *
     * @return void
     */
    public function testMainUrlFormatAfterSet()
    {
        $project = new Project;
        $project->main_url = 'http://example.com';
        $this->assertEquals('http://example.com', $project->main_url);
    }

    /**
     * Test get updated_at attribute with custom format
     *
     * @return void
     */
    public function testUpdatedAtFormat()
    {
        $project = new Project;
        $time = \Carbon\Carbon::now();
        $project->updated_at = $time;
        $this->assertEquals($time->format('H:i M j, Y'), $project->updated_at);
    }

    /**
     * Test get query scope of findBySlug method
     *
     * @return void
     */
    public function testScopeFindBySlug()
    {
        $userFaker = factory(User::class)->create(['name' => 'test']);
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);

        $project = new Project;

        $this->assertInstanceOf(Project::class, $project->findBySlug('example'));
    }
}
