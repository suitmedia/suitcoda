<?php

namespace Suitcoda\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;
use Suitcoda\Model\User;

class Project extends BaseModel implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'projects';

    protected $url_key = 'slug';

    protected $fillable = [
        'name',
        'slug',
        'main_url',
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
}
