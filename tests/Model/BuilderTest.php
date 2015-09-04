<?php

namespace SuitTests\Model;

use Mockery;
use SuitTests\TestCase;
use Suicoda\Model\Builder;
use Illuminate\Database\Eloquent\Collection;

class BuilderTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    public function testFindByUrlKeyWithMany()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->setModel($this->getMockModel());
        $builder->shouldReceive('get')->with(['column'])->andReturn('baz');
        $result = $builder->findByUrlKey([1, 2], ['column']);
        $this->assertEquals('baz', $result);
    }

    public function testFindOrFailByUrlKeyWithMany()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->setModel($this->getMockModel());
        $builder->shouldReceive('get')->with(['column'])->andReturn(['baz', 'bar']);
        $result = $builder->findOrFailByUrlKey([1, 2], ['column']);
    }

    public function testFindOrFailByUrlKeyWithEmptyId()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->setModel($this->getMockModel());
        $result = $builder->findByUrlKeyMany(null);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFindOrFailMethodWithManyThrowsModelNotFoundException()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->setModel($this->getMockModel());
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->shouldReceive('get')->with(['column'])->andReturn(new Collection([1]));
        $result = $builder->findOrFailByUrlKey([1, 2], ['column']);
    }

    protected function getMockModel()
    {
        $model = Mockery::mock('Suitcoda\Model\BaseModel');
        $model->shouldReceive('getUrlKeyName')->andReturn('foo');
        $model->shouldReceive('getTable')->andReturn('foo_table');
        $model->shouldReceive('getQualifiedUrlKeyName')->andReturn('foo_table.foo');
        $model->shouldReceive('newCollection');
        return $model;
    }

    protected function getMockQueryBuilder()
    {
        $query = Mockery::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('from')->with('foo_table');
        return $query;
    }
}
