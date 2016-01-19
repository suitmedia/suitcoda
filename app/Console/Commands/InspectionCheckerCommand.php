<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
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
     * @param Inspection $inspection []
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
            $this->isMany($inspections);
        });
    }

    /**
     * Check inspections one or many
     *
     * @param  Collection $inspections []
     * @return void
     */
    public function isMany($inspections)
    {
        if ($inspections->count() > 1) {
            $this->checkAll($inspections);
        } else {
            $this->check($inspections);
        }
    }

    /**
     * Check Inspections
     *
     * @param  Collection $inspections []
     * @return void
     */
    public function checkAll($inspections)
    {
        foreach ($inspections as $inspection) {
            $this->check($inspection);
        }
    }

    /**
     * Check Inspections
     *
     * @param  Collection $inspection []
     * @return void
     */
    public function check($inspection)
    {
        if (is_null($inspection)) {
            return;
        }
        if ($inspection->jobInspects()->get()->isEmpty()) {
            return;
        }
        foreach ($inspection->jobInspects()->get() as $job) {
            if ($job->status == '1' || $job->status == '0') {
                return;
            }
        }

        $this->calc->calculate($inspection);

        $inspection->update(['status' => 2, 'score' => round($inspection->scores()->sum('score'), 2)]);
    }
}
