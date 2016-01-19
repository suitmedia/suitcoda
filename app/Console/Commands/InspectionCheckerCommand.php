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
            foreach ($inspections as $inspection) {
                if (is_null($inspection)) {
                    continue;
                }
                if ($inspection->jobInspects()->get()->isEmpty()) {
                    continue;
                }
                foreach ($inspection->jobInspects()->get() as $job) {
                    if ($job->status == '1' || $job->status == '0') {
                        continue 2;
                    }
                }

                $this->calc->calculate($inspection);

                $inspection->update(['status' => 2, 'score' => round($inspection->scores()->sum('score'), 2)]);
            }
        });
    }
}
