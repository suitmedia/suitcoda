<?php

namespace SuitTests\Console\Commands;

use Illuminate\Database\Eloquent\Collection;
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

        $inspection->shouldReceive('progress->chunk')->andReturn($inspectionFaker);
        
        $inspectionChecker->handle();
    }

    public function testCheckAll()
    {
        $inspectionsFaker = factory(Inspection::class, 5)->create();

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspectionChecker->checkAll($inspectionsFaker);
    }

    public function testCheckEmptyJobObject()
    {
        $inspectionFaker = factory(Inspection::class)->create();

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspectionChecker->check($inspectionFaker);
    }

    public function testCheckWithJobObject()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(JobInspect::class, 5)->create([
            'inspection_id' => $inspectionFaker->id
        ]);

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $inspectionChecker->check($inspectionFaker);
    }

    public function testCheckWithJobFinishObject()
    {
        $inspectionFaker = factory(Inspection::class)->create();
        factory(JobInspect::class, 5)->create([
            'inspection_id' => $inspectionFaker->id,
            'status' => 2
        ]);

        $inspection = Mockery::mock(Inspection::class);
        $calc = Mockery::mock(CalculateScore::class);
        $inspectionChecker = new InspectionCheckerCommand($inspection, $calc);

        $calc->shouldReceive('calculate');

        $inspectionChecker->check($inspectionFaker);
    }
}
