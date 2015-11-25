<?php
namespace Suitcoda\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseModel extends Model
{
    /**
     * Key used for SEO in url. This attribute must be unique.
     * @var string
     */
    protected $urlKey = 'id';


    /**
     * Get value used for SEO in url
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getAttribute($this->getUrlKeyName());
    }


    /**
     * {@inheritdoc}
     */
    public function getRouteKeyName()
    {
        return $this->getUrlKeyName();
    }


    /**
     * Get field name which is used in getUrlKey() to get the value
     * @return string
     */
    public function getUrlKeyName()
    {
        return $this->urlKey;
    }

    /**
     * Get field name used for SQL query. This method will add table name as the prefix.
     * @return string
     */
    public function getQualifiedUrlKeyName()
    {
        return sprintf("%s.%s", $this->getTable(), $this->getUrlKeyName());
    }

    /**
     * @{inheritdoc}
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
