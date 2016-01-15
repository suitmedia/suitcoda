<?php

namespace SuitTests\Console\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Console\Commands\InspectionCheckerCommand;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Supports\CalculateScore;

class InspectionCheckerCommandTest extends TestCase
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
     * Test handle InspectionCheckerCommand
     *
     * @return void
     */
    public function testHandle()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(JobInspect::class)->create();

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspection->shouldReceive('progress->get->first')->andReturn($inspectionFaker);
        $calc->shouldReceive('calculate');
        $inspection->shouldReceive('update')->andReturn(true);
        
        $inspectionChecker->handle();
    }

    public function testHandleNullObject()
    {
        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspection->shouldReceive('progress->get->first')->andReturn(null);
        
        $inspectionChecker->handle();
    }

    public function testHandleUpdateJobToStopped()
    {
        $jobFaker = factory(JobInspect::class, 5)->create();

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspection->shouldReceive('progress->get->first')->andReturn($inspection);
        $inspection->shouldReceive('jobInspects->get')->andReturn($jobFaker);
        $calc->shouldReceive('calculate');
        $inspection->shouldReceive('update')->andReturn(true);
        
        $inspectionChecker->handle();
    }
}
