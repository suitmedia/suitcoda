<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Suitcoda\Model\Issue;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Score;
use Suitcoda\Model\SubScope;

class Inspection extends BaseModel
{
    protected $table = 'inspections';

    protected $fillable = [
        'sequence_number',
        'scopes',
        'status',
        'score',
    ];

    /**
     * Get the project for the current inspection.
     *
     * @return object
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the jobInspects for the current inspection.
     *
     * @return object
     */
    public function jobInspects()
    {
        return $this->hasMany(JobInspect::class);
    }

    /**
     * Get the scores for the current inspection.
     *
     * @return object
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get the issues for the current inspection.
     *
     * @return object
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * Get score attribute with format
     *
     * @return string
     */
    public function getScoreAttribute()
    {
        if ($this->attributes['score']) {
            return $this->attributes['score'];
        }
        return '-';
    }

    /**
     * Get status attribute in string
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        if ($this->attributes['status'] == 0) {
            return 'Waiting';
        }
        if ($this->attributes['status'] == 1) {
            return 'On Progress';
        }
        if ($this->attributes['status'] == 2) {
            return 'Completed';
        }
        return 'Stopped';
    }

    /**
     * Get status text color label attribute in string
     *
     * @return string
     */
    public function getStatusTextColorAttribute()
    {
        if ($this->attributes['status'] == 0) {
            return 'grey';
        }
        if ($this->attributes['status'] == 1) {
            return 'orange';
        }
        if ($this->attributes['status'] == 2) {
            return 'green';
        }
        return 'red';
    }

    /**
     * Get updated_at attribute in new format
     *
     * @param string $value []
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $time = new Carbon($value);
        return $time->diffForHumans();
    }

    /**
     * Get used scopes in current inspection
     *
     * @return array
     */
    public function getScopeListAttribute()
    {
        $scopes = (int)$this->attributes['scopes'];
        foreach (SubScope::all() as $subScope) {
            if (($scopes & $subScope->code) > 0) {
                $scopeList[] = $subScope->scope->category;
            }
        }
        return collect(array_unique($scopeList));
    }

    /**
     * Get related last inspection score by category
     *
     * @param string $name []
     * @return string
     */
    public function getScoreByCategory($name)
    {
        $scoreByCategory = $this->scores()->byCategoryName($name)->first();
        if ($scoreByCategory) {
            return $scoreByCategory->score . '%';
        }
        return '-';
    }

    /**
     * Get related inspection total issue
     *
     * @return string
     */
    public function getIssuesAttribute()
    {
        if ($this->attributes['status'] == 2) {
            return $this->issues()->get()->count();
        }
    }

    /**
     * Scope a query to get inspections of a given sequence number.
     *
     * @param  string $query []
     * @param  string $number []
     * @return object
     */
    public function scopeBySequenceNumber($query, $number)
    {
        return $query->where('sequence_number', $number);
    }

    /**
     * Related query to get inspections of a given category name.
     *
     * @param  string $category []
     * @return object|null
     */
    public function getIssueListByCategory($category)
    {
        if ($this->attributes['status'] == 2) {
            return $this->issues()->byCategoryName($category)->get();
        }
        return null;
    }

    /**
     * Scope a query to get inspections of a given id.
     *
     * @param  string $query []
     * @param  string $keyId []
     * @return object
     */
    public function scopeGetById($query, $keyId)
    {
        return $query->where('id', $keyId)->get();
    }

    /**
     * Scope a query to get completed inspections order desc.
     *
     * @param  string $query []
     * @return object
     */
    public function scopeLatestCompleted($query)
    {
        return $query->where('status', 2)->latest();
    }
}
