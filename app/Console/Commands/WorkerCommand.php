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
            $this->updateJob($unhandledJob, 1);
            $result = true;
            $count = 3;
            while ($result && $count > 0) {
                $output = $this->runCommand($unhandledJob->command_line);
                if (str_contains($output, 'terminated')) {
                    \Log::error($output . "Retry : " . $count);
                }
                $this->resultReader->setJob($unhandledJob);
                $result = $this->resultReader->run();
                $count--;
            }
            if ($result) {
                $this->updateJob($unhandledJob, -1);
            }
        } else {
            sleep(5);
        }
    }

    /**
     * Update jobInspect status
     *
     * @param  JobInspect $job    []
     * @param  int     $status []
     * @return void
     */
    public function updateJob(JobInspect $job, $status)
    {
        $job->update(['status' => $status]);
    }

    /**
     * Run external program
     *
     * @param  string $command []
     * @return string
     */
    public function runCommand($command)
    {
        return `./worker_script $command`;
    }
}
