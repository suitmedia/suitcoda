<?php
namespace Suitcoda\Model\Extension;

use Illuminate\Support\Str;

trait SluggableTrait
{
    /**
     * Trait boot
     *
     * @return void
     */
    public static function bootSluggableTrait()
    {

        static::creating(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Generate slug
     *
     * @return string
     */
    public function generateSlug()
    {
        $with = $this->getSlugWith();
        $slug = Str::slug($this->$with);

        $lists = $this->getExistingSlug($slug)->all();

        if (!empty($lists) && in_array($slug, $lists)) {
            $len = strlen($slug.$this->getSeparator());
            array_walk($lists, function (&$value, $key) use ($len) {
                $value = intval(substr($value, $len));
            });

            rsort($lists);
            $increment = reset($lists) + 1;

            $slug .= $this->getSeparator().$increment;
        }

        $this->setSlug($slug);
        return $slug;
    }

    /**
     * Get Existing slug from this model
     *
     * @param string $slug
     * @return array
     */
    protected function getExistingSlug($slug)
    {
        $instance = $this->newInstance();
        $query = $instance->newQuery();
        
        $query = $query->where($this->getSlugField(), 'LIKE', $slug.'%');

        // if use soft delete trait
        if (method_exists($instance, 'withTrashed')) {
            $query = $query->withTrashed();
        }

        return $query->get()->lists($this->getSlugField(), $this->getKeyName());
    }

    /**
     * Get slug column name
     *
     * @return string
     */
    public function getSlugField()
    {
        return 'slug';
    }

    /**
     * Get slug source field
     *
     * @return string
     */
    protected function getSlugWith()
    {
        if (!isset($this->slug_with) || empty($this->slug_with)) {
            throw new Exception('slug_with is not instantiate or empty');
        }
        if (!is_string($this->slug_with)) {
            throw new Exception("slug_with must be string");
        }

        return $this->slug_with;
    }

    /**
     * Get separator used for slug
     *
     * @return string
     */
    public function getSeparator()
    {
        return '-';
    }

    /**
     * Get slug string
     *
     * @return string
     */
    public function getSlug()
    {
        $slugname = $this->getSlugField();
        return $this->$slugname;
    }

    /**
     * set slug
     *
     * @param string $value
     * @return void
     */
    public function setSlug($value)
    {
        $slugname = $this->getSlugField();
        if (empty($this->$slugname)) {
            $this->$slugname = $value;
        }
    }
}
