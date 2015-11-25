<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Suicoda\Model\Builder;
use SuitTests\TestCase;

class BuilderTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test with findByUrlKey
     *
     * @return void
     */
    public function testFindByUrlKeyWithMany()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->setModel($this->getMockModel());
        $builder->shouldReceive('get')->with(['column'])->andReturn('baz');
        $result = $builder->findByUrlKey([1, 2], ['column']);
        $this->assertEquals('baz', $result);
    }

    /**
     * Test with findOrFailByUrlKey
     *
     * @return void
     */
    public function testFindOrFailByUrlKeyWithMany()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->setModel($this->getMockModel());
        $builder->shouldReceive('get')->with(['column'])->andReturn(['baz', 'bar']);
        $result = $builder->findOrFailByUrlKey([1, 2], ['column']);
        $this->assertEquals(['baz', 'bar'], $result);
    }

    /**
     * Test with findOrFailByUrlKey null value
     *
     * @return void
     */
    public function testFindOrFailByUrlKeyWithEmptyId()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->setModel($this->getMockModel());
        $result = $builder->findByUrlKeyMany(null);
        $this->assertNull($result);
    }

    /**
     * Test to throw the expected exception
     *
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     * @return void
     */
    public function testFindOrFailMethodWithManyThrowsModelNotFoundException()
    {
        $builder = Mockery::mock('Suitcoda\Model\Builder[get]', [$this->getMockQueryBuilder()]);
        $builder->setModel($this->getMockModel());
        $builder->getQuery()->shouldReceive('whereIn')->once()->with('foo_table.foo', [1, 2]);
        $builder->shouldReceive('get')->with(['column'])->andReturn(new Collection([1]));
        $builder->findOrFailByUrlKey([1, 2], ['column']);
    }

    /**
     * Get mock base model
     *
     * @return Mockery
     */
    protected function getMockModel()
    {
        $model = Mockery::mock('Suitcoda\Model\BaseModel');
        $model->shouldReceive('getUrlKeyName')->andReturn('foo');
        $model->shouldReceive('getTable')->andReturn('foo_table');
        $model->shouldReceive('getQualifiedUrlKeyName')->andReturn('foo_table.foo');
        $model->shouldReceive('newCollection');
        return $model;
    }

    /**
     * Get mock query builder
     *
     * @return Mockery
     */
    protected function getMockQueryBuilder()
    {
        $query = Mockery::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('from')->with('foo_table');
        return $query;
    }
}
