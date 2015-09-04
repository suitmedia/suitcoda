<?php
namespace Suitcoda\Model;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Builder extends BaseBuilder
{
    /**
     * Find a model by its Url key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null
     */
    public function findByUrlKey($id, $columns = array('*'))
    {
        if (is_array($id)) {
            return $this->findByUrlKeyMany($id, $columns);
        }

        $this->query->where($this->model->getQualifiedUrlKeyName(), '=', $id);

        return $this->first($columns);
    }

    /**
     * Find a model by its url key.
     *
     * @param  array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByUrlKeyMany($ids, $columns = array('*'))
    {
        if (empty($ids)) {
            return $this->model->newCollection();
        }

        $this->query->whereIn($this->model->getQualifiedUrlKeyName(), $ids);

        return $this->get($columns);
    }

    /**
     * Find a model by its url key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailByUrlKey($id, $columns = array('*'))
    {
        $result = $this->findByUrlKey($id, $columns);

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }
}
