<?php

namespace Suitcoda\Model;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
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
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i M j, Y');
        return $time;
    }

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
     * Scope a query to get project with the given slug.
     *
     * @param string $query []
     * @param string $slug []
     * @return object
     */
    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->get();
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
}
