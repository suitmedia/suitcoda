<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Model\JobInspect;
use Suitcoda\Supports\ResultReader;

class WorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worker:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    protected $job;

    protected $resultReader;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JobInspect $job, ResultReader $resultReader)
    {
        parent::__construct();
        $this->job = $job;
        $this->resultReader = $resultReader;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $unhandledJob = $this->job->getUnhandledJob()->first();
        $unhandledJob->update(['status' => 1]);
        `$unhandledJob->command_line`;
        $this->resultReader->setJob($unhandledJob);
        $this->resultReader->run();
    }
}
