<?php

namespace SuitTests\Console\Commands;

use Illuminate\Console\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Console\Commands\CreateSeoJsonCommand;
use Suitcoda\Model\Url;
use Suitcoda\Supports\SeoBackProcess;
use SuitTests\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Test Suitcoda\Console\Commands\CreateSeoJsonCommand
 */

class CreateSeoJsonCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test continue if user success save to database
     *
     * @return void
     */
    public function testHandle()
    {
        $checker = Mockery::mock(SeoBackProcess::class);
        $command = Mockery::mock('Suitcoda\Console\Commands\CreateSeoJsonCommand[option, argument]', [$checker]);

        $command->shouldReceive('option')->once();
        $command->shouldReceive('argument')->twice();
        $checker->shouldReceive('setUrl');
        $checker->shouldReceive('setDestination');
        $checker->shouldReceive('setOption');
        $checker->shouldReceive('run');

        $command->handle();
    }
}
