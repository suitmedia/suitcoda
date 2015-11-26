<?php
namespace Suitcoda\Model;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Builder extends BaseBuilder
{
    /**
     * Find a model by its Url key.
     *
     * @param  mixed  $keyId []
     * @param  array  $columns []
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null
     */
    public function findByUrlKey($keyId, $columns = ['*'])
    {
        if (is_array($keyId)) {
            return $this->findByUrlKeyMany($keyId, $columns);
        }

        $this->query->where($this->model->getQualifiedUrlKeyName(), '=', $keyId);

        return $this->first($columns);
    }

    /**
     * Find a model by its url key.
     *
     * @param  array  $keyIds []
     * @param  array  $columns []
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByUrlKeyMany($keyIds, $columns = ['*'])
    {
        if (empty($keyIds)) {
            return $this->model->newCollection();
        }

        $this->query->whereIn($this->model->getQualifiedUrlKeyName(), $keyIds);

        return $this->get($columns);
    }

    /**
     * Find a model by its url key or throw an exception.
     *
     * @param  mixed  $keyId []
     * @param  array  $columns []
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailByUrlKey($keyId, $columns = ['*'])
    {
        $result = $this->findByUrlKey($keyId, $columns);

        if (is_array($keyId)) {
            if (count($result) == count(array_unique($keyId))) {
                return $result;
            }
        } elseif (!is_null($result)) {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }
}
