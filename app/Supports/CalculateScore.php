<?php

namespace Suitcoda\Supports;

use Suitcoda\Model\Category;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;

class CalculateScore
{
    protected $score;

    protected $category;

    /**
     * Class constructor
     *
     * @param Score $score []
     * @param Scope $category []
     */
    public function __construct(Score $score, Category $category)
    {
        $this->score = $score;
        $this->category = $category;
    }

    /**
     * Calculate score for one inspection
     *
     * @param  Inspection $inspection []
     * @return void
     */
    public function calculate($inspection)
    {
        foreach ($inspection->jobInspects as $job) {
            if ($job->status != 2) {
                return;
            }
        }

        foreach ($this->category->all() as $category) {
            $jobs = $inspection->jobInspects->filter(function ($item) use ($category) {
                return $item->scope->category_id == $category->id;
            });

            if (!$jobs->isEmpty()) {
                $counter = 0;
                foreach ($jobs as $job) {
                    $counter += $job->issue_count;
                }
                $score = $this->score->newInstance();
                $score->score = $counter / $inspection->project->urls->count();
                $score->inspection()->associate($inspection);
                $score->category()->associate($category);
                $score->save();
            }
        }
    }
}
