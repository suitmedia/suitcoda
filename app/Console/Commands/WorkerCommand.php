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
        if ($unhandledJob) {
            $unhandledJob->update(['status' => 1]);
            $result = true;
            $count = 3;
            while ($result && $count > 1) {
                $output = `./worker_script $unhandledJob->command_line`;
                if ($output) {
                    \Log::error($output);
                }
                $this->resultReader->setJob($unhandledJob);
                $result = $this->resultReader->run();
                $count--;
            }
        } else {
            sleep(5);
        }
    }
}
