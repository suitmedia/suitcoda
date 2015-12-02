<?php

namespace SuitTests\Listeners;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Listeners\JobGenerator;
use Suitcoda\Model\Builder;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\CommandLineGenerator;
use SuitTests\TestCase;

class JobGeneratorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test handle
     *
     * @return void
     */
    public function testHandle()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(Url::class, 5)->create([
            'project_id' => $inspectionFaker->project->id
        ]);

        $project = Mockery::mock(Project::class);
        $generator = Mockery::mock(CommandLineGenerator::class . '[generateCommand]', [new Scope]);
        $job = Mockery::mock(JobInspect::class . '[newInstance, save]')->makePartial();

        $project->shouldReceive('urls->active->byType->get')->andReturn(2);
        $generator->shouldReceive('getByType')->andReturn(new Collection([Scope::find(1)]));
        $generator->shouldReceive('generateCommand')->andReturn(1);
        $job->shouldReceive('newInstance')->andReturn($job);
        $job->shouldReceive('save')->andReturn(true);

        $listener = new JobGenerator($generator, $job);
        $listener->handle(new ProjectWatcher($inspectionFaker->project, $inspectionFaker));
    }
}
