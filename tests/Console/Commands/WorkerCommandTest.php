<?php

namespace SuitTests\Console\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Console\Commands\WorkerCommand;
use Suitcoda\Model\JobInspect;
use Suitcoda\Supports\ResultReader;

class WorkerCommandTest extends TestCase
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
     * Test handle WorkerCommand
     *
     * @return void
     */
    public function testHandle()
    {
        $jobFaker = factory(JobInspect::class)->create();

        $job = Mockery::mock(JobInspect::class);
        $reader = Mockery::mock(ResultReader::class);
        $worker = Mockery::mock(WorkerCommand::class . '[updateJob, runCommand]', [$job, $reader]);

        $job->shouldReceive('getUnhandledJob->first')->andReturn($jobFaker);
        $reader->shouldReceive('setJob');
        $reader->shouldReceive('run')->andReturn(true);
        $worker->shouldReceive('updateJob')->twice();
        $worker->shouldReceive('runCommand')->andReturn('process died');
        \Log::shouldReceive('error');

        $worker->handle();
    }

    public function testHandleSleep()
    {
        $job = Mockery::mock(JobInspect::class);
        $reader = Mockery::mock(ResultReader::class);
        $worker = new WorkerCommand($job, $reader);

        $job->shouldReceive('getUnhandledJob->first')->andReturn(null);

        $worker->handle();
    }

    public function testUpdateJob()
    {
        $job = Mockery::mock(JobInspect::class);
        $reader = Mockery::mock(ResultReader::class);
        $worker = new WorkerCommand($job, $reader);

        $job->shouldReceive('update')->andReturn(true);

        $worker->updateJob($job, 1);
    }
}
