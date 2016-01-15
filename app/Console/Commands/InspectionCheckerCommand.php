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
        $inspection = $this->inspection->progress()->get()->first();
        if (is_null($inspection)) {
            return;
        }
        if ($inspection->jobInspects()->get()->isEmpty()) {
            return;
        }
        foreach ($inspection->jobInspects as $job) {
            if ($job->status < 0) {
                $inspection->update(['status' => (-1)]);
            }
            if ($job->status < 2) {
                return;
            }
        }

        $this->calc->calculate($inspection);

        $inspection->update(['status' => 2, 'score' => round($inspection->scores()->sum('score'), 2)]);
    }
}
