<?php

namespace SuitTests\Listeners;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Listeners\JobGenerator;
use Suitcoda\Model\Builder;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\ScopesCheckerGenerator;

class JobGeneratorTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testHandle()
    {
        $userFaker = factory(User::class)->create(['name' => 'test']);
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        for ($i=0; $i < 2; $i++) {
            $urlFaker = factory(Url::class)->make();
            $projectFaker->urls()->save($urlFaker);
            $inspectionFaker = factory(Inspection::class)->make();
            $projectFaker->inspections()->save($inspectionFaker);
        }

        $project = Mockery::mock(Project::class);
        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $generator = Mockery::mock(ScopesCheckerGenerator::class);
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
        $listener->handle(new ProjectWatcher($projectFaker, $inspectionFaker));
    }
}
