<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Suitcoda\Model\Inspection;
use Suitcoda\Supports\CalculateScore;

class InspectionCheckerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspection:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $inspection;

    protected $calc;

    /**
     * Create a new command instance.
     *
     * @param \Suitcoda\Model\Inspection $inspection []
     * @param \Suitcoda\Supports\CalculateScore $calc []
     * @return void
     */
    public function __construct(Inspection $inspection, CalculateScore $calc)
    {
        parent::__construct();
        $this->inspection = $inspection;
        $this->calc = $calc;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->inspection->progress()->chunk(100, function ($inspections) {
            $this->checkAll($inspections);
        });
    }

    /**
     * Check Inspections
     *
     * @param  \Illuminate\Database\Eloquent\Collection $inspections []
     * @return void
     */
    public function checkAll(Collection $inspections)
    {
        foreach ($inspections as $inspection) {
            $this->check($inspection);
        }
    }

    /**
     * Check Inspections
     *
     * @param  \Suitcoda\Model\Inspection $inspection []
     * @return void
     */
    public function check(Inspection $inspection)
    {
        $jobs = $inspection->jobInspects()->get();
        if ($jobs->isEmpty()) {
            return;
        }
        
        foreach ($jobs as $job) {
            if ($job->status == '1' || $job->status == '0') {
                return;
            }
        }

        $this->calc->calculate($inspection);
    }
}
