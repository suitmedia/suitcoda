<?php

namespace Suitcoda\Supports;

use Suitcoda\Model\Scope;
use Suitcoda\Model\Score;

class CalculateScore
{
    protected $score;

    protected $scope;

    protected $category;

    /**
     * Class constructor
     *
     * @param Score $score []
     * @param Scope $scope []
     */
    public function __construct(Score $score, Scope $scope)
    {
        $this->score = $score;
        $this->scope = $scope;
    }

    /**
     * Add score to database
     *
     * @param Inspection $inspection []
     * @param string $category []
     * @return void
     */
    public function addScore($inspection, $category)
    {
        $this->category = $category;
        $jobs = $inspection->jobInspects->filter(function ($item) {
            return $item->scope->category == $this->category;
        });
        if (!$jobs->isEmpty()) {
            $counter = 0;
            foreach ($jobs as $job) {
                $counter += $job->issue_count;
            }
            $score = $this->score->newInstance();
            $score->category = $jobs->first()->scope->category;
            $score->score = $counter / $jobs->count();
            $score->inspection()->associate($inspection);
            $score->save();
        }
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

        $scopeCategory = $this->scope->all()->pluck('category');

        foreach ($scopeCategory as $category) {
            $this->addScore($inspection, $category);
        }
    }
}
