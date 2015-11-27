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

        $project = Mockery::mock(Project::class);
        $generator = Mockery::mock(CommandLineGenerator::class);
        $job = Mockery::mock(JobInspect::class)->makePartial();
        $url = Mockery::mock(Url::class);
        $builder = Mockery::mock(Builder::class);

        $project->shouldReceive('urls')->andReturn($url);
        $url->shouldReceive('active')->andReturn($url);
        $url->shouldReceive('byType')->andReturn($builder);
        $builder->shouldReceive('get')->andReturn(new Collection(['a', 'b']));
        $generator->shouldReceive('getByType')->andReturn(new Collection([Scope::find(1)]));
        $generator->shouldReceive('generateCommand')->andReturn(1);
        $generator->shouldReceive('generateUrl')->andReturn(1);
        $generator->shouldReceive('generateParameters')->andReturn(1);
        $generator->shouldReceive('generateDestination')->andReturn(1);
        $job->shouldReceive('newInstance')->andReturn($job);
        $job->shouldReceive('save')->andReturn(true);

        $listener = new JobGenerator($generator, $job);
        $listener->handle(new ProjectWatcher($inspectionFaker->project, $inspectionFaker));
    }
}
