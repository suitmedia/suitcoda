<?php

namespace Suitcoda\Supports;

use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
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
    public function calculate(Inspection $inspection)
    {
        foreach ($inspection->scopeList as $category) {
            $uniqueUrlInIssues = $inspection->issues()->byCategorySlug($category->slug)->error()->distinct()
                                            ->select('url')->get()
                                            ->count();
            $uniqueUrlInJobs = $inspection->jobInspects()->byCategorySlug($category->slug)->distinct()
                                          ->select(['url_id', 'scope_id'])->get()
                                          ->count();
            $errorRate = $uniqueUrlInIssues / $uniqueUrlInJobs;

            $score = $this->score->findOrNewByRelatedId($inspection->getKey(), $category->getKey());
            $score->score = round($errorRate, 2);
            $score->inspection()->associate($inspection);
            $score->category()->associate($category);
            $score->save();
        }

        $alUniqueUrlInIssues = $inspection->issues()->error()->distinct()->select('url')->get()->count();
        $alUniqueUrlInJobs = $inspection->jobInspects()->distinct()->select(['url_id', 'scope_id'])->get()->count();
        $overallErrorRate = $alUniqueUrlInIssues / $alUniqueUrlInJobs;
        
        $inspection->update(['status' => 2, 'score' => round($overallErrorRate, 2)]);
    }
}
