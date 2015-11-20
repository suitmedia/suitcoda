<?php

namespace Suitcoda\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;
use Suitcoda\Model\User;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Url;

class Project extends BaseModel implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'projects';

    protected $url_key = 'slug';

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

    public function getMainUrlAttribute($value)
    {
        if (!isset($value)) {
            $url_prefix = 'http://';
            return url(sprintf('%s', $url_prefix));
        }
        return $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('H:i M j, Y');
        return $time;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function urls()
    {
        return $this->hasMany(Url::class);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->get();
    }
}
