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
        $worker = new WorkerCommand($job, $reader);

        $job->shouldReceive('getUnhandledJob->first')->andReturn($jobFaker);
        $job->shouldReceive('update')->andReturn(true);
        $reader->shouldReceive('setJob');
        $reader->shouldReceive('run');

        $worker->handle();

        $this->seeInDatabase('job_inspects', [
            'id' => $jobFaker->id,
            'status' => 1
        ]);
    }
}
