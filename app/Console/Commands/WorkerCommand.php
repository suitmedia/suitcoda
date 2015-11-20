<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Model\JobInspect;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JobInspect $job)
    {
        parent::__construct();
        $this->job = $job;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $unhandledJob = $this->job->getUnhandledJob()->first();
        // $unhandledJob->update(['status' => 1]);
        // `$unhandledJob->command_line`;
        // $resultReader->setJob($unhandledJob);
        // $resultReader->run();
        // $unhandledJob->update(['status' => 2);
    }
}
