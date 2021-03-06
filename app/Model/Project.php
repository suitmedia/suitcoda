<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;

class Project extends BaseModel implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'projects';

    protected $urlKey = 'slug';

    protected $fillable = [
        'name',
        'slug',
        'main_url',
        'is_crawlable'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

    /**
     * Get the user for the current project.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the inspections for the current project.
     *
     * @return object
     */
    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    /**
     * Get the urls for the current project.
     *
     * @return object
     */
    public function urls()
    {
        return $this->hasMany(Url::class);
    }

    /**
     * Get main url with http prefix
     *
     * @param  string $value []
     * @return string
     */
    public function getMainUrlAttribute($value)
    {
        if (!isset($value)) {
            $urlPrefix = 'http://';
            return url(sprintf('%s', $urlPrefix));
        }
        return $value;
    }

    /**
     * Get updated_at variable with the given format
     *
     * @param  string $value []
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $time = new Carbon($value);
        return $time->diffForHumans();
    }

    /**
     * Get first inspection object in desc order
     *
     * @return object
     */
    public function getLastInspection()
    {
        return $this->inspections()->latest()->first();
    }

    /**
     * Get first completed inspection object in desc order
     *
     * @return object
     */
    public function getLastCompletedInspection()
    {
        return $this->inspections()->latestCompleted()->first();
    }

    /**
     * Get related last inspection score
     *
     * @return string
     */
    public function getLastInspectionScoreAttribute()
    {
        if ($this->getLastInspection()) {
            return $this->getLastInspection()->score . (is_string($this->getLastInspection()->score) ? '' : '%');
        }
        return '-';
    }

    /**
     * Get related last inspection number
     *
     * @return string
     */
    public function getLastInspectionNumberAttribute()
    {
        if ($this->getLastInspection()) {
            return '#' . $this->getLastInspection()->sequence_number;
        }
        return '-';
    }

    /**
     * Get related last inspection status
     *
     * @return string
     */
    public function getLastInspectionStatusAttribute()
    {
        if ($this->getLastInspection()) {
            return '<b class="text-' . $this->getLastInspection()->statusTextColor . '">' .
                $this->getLastInspection()->statusName . '</b>';
        }
        return '-';
    }

    /**
     * Get related last  completed inspection score
     *
     * @return string
     */
    public function getLastCompletedInspectionScoreAttribute()
    {
        if ($this->getLastCompletedInspection()) {
            return $this->getLastCompletedInspection()->score;
        }
        return '-';
    }

    /**
     * Get related last  completed inspection Issues
     *
     * @return string
     */
    public function getLastCompletedInspectionIssuesAttribute()
    {
        if ($this->getLastCompletedInspection()) {
            return $this->getLastCompletedInspection()->issues;
        }
        return '-';
    }

    /**
     * Get related last inspection score by category
     *
     * @param string $slug []
     * @return string
     */
    public function getLastCompletedInspectionScoreByCategory($slug)
    {
        $inspection = $this->getLastCompletedInspection();
        if ($inspection) {
            if ($inspection->scores()->byCategorySlug($slug)->first()) {
                return $inspection->scores()->byCategorySlug($slug)->first()->score;
            }
        }
        return '-';
    }

    /**
     * Get related last inspection issue by category
     *
     * @param string $slug []
     * @return string
     */
    public function getLastCompletedInspectionIssueByCategory($slug)
    {
        $inspection = $this->getLastCompletedInspection();
        if ($inspection) {
            if (!$inspection->issues()->byCategorySlug($slug)->get()->isEmpty()) {
                return $inspection->issues()->byCategorySlug($slug)->get()->count();
            }
        }
        return '-';
    }

    /**
     * Scope to search project by name
     *
     * @param  string $query   []
     * @param  string $keyword []
     * @return object
     */
    public function scopeSearch($query, $keyword)
    {
        $keywords = explode(' ', $keyword);
        $regex = '';

        if (\DB::connection()->getName() == 'mysql') {
            $regex = 'REGEXP';
        } elseif (\DB::connection()->getName() == 'pgsql') {
            $regex = '~';
        }

        $result = $query->where(function ($q) use ($keywords, $regex) {
            foreach ($keywords as $key) {
                $q->orWhere('name', $regex, "[[:<:]]{$key}[[:>:]]");
            }
        });

        return $result;
    }

    /**
     * Generate json data for graph
     *
     * @return array
     */
    public function getJsonData()
    {
        $graphData = [];
        $count = 0;
        $listGraph = array_merge(['overall' => 'Overall'], Category::lists('name', 'slug')->toArray());
        $graphData = array_add($graphData, 'title', $this->name);
        $graphData = array_add($graphData, 'series', []);
        $graphData = array_add($graphData, 'xAxis', []);

        $inspections = $this->inspections()->limit(10)->get();
        $inspectionsScore = $inspections->map(function ($item) {
            if ($item->status == '2') {
                return (double)$item->score;
            }
            return null;
        })->toArray();

        foreach ($this->inspections as $inspection) {
            array_push($graphData['xAxis'], '#' . $inspection->sequence_number);
        }

        foreach ($listGraph as $slug => $name) {
            array_set($series, $count . '.name', $name);

            if ($slug == 'overall') {
                array_set(
                    $series,
                    $count . '.data',
                    $inspectionsScore
                );
            } else {
                array_set($series, $count . '.data', $this->getScoreByCategorySlug($inspections, $slug));
            }
            $count++;
        }
        array_set($graphData, 'series', $series);
        return $graphData;
    }

    /**
     * Get scores for json by given category slug
     * @param  array $inspections []
     * @param  string $slug []
     * @return array
     */
    protected function getScoreByCategorySlug($inspections, $slug)
    {
        $scores = [];
        foreach ($inspections as $inspection) {
            $scoreObj = $inspection->scores()->byCategorySlug($slug)->first();
            if ($scoreObj) {
                $scoreValue = (double)$scoreObj->score;
            } else {
                $scoreValue = null;
            }
            $scores[] = $scoreValue;
        }
        return $scores;
    }

    /**
     *
     * @return string
     */
    public function getLastCompletedInspectionUrlPercentageAttribute()
    {
        if ($this->getLastCompletedInspection()) {
            return $this->getLastCompletedInspection()->uniqueUrlIssue() . '/' .
                   $this->getLastCompletedInspection()->uniqueUrlJob();
        }
        return '-';
    }

    /**
     *
     * @param string $slug []
     * @return string
     */
    public function getLastCompletedInspectionUrlPercentageByCategory($slug)
    {
        $inspection = $this->getLastCompletedInspection();
        if ($inspection) {
            if (!$inspection->issues()->byCategorySlug($slug)->get()->isEmpty()) {
                return $inspection->uniqueUrlIssueByCategory($slug) . '/' .
                       $inspection->uniqueUrlJobByCategory($slug);
            }
        }
        return '-';
    }
}
