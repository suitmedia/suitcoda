<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Category;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Category with scope
     *
     * @return void
     */
    public function testRelationshipWithScope()
    {
        $category = new Category;

        $this->assertInstanceOf(HasMany::class, $category->scopes());
    }

    /**
     * Test Relationship Category with score
     *
     * @return void
     */
    public function testRelationshipWithScore()
    {
        $category = new Category;

        $this->assertInstanceOf(HasMany::class, $category->scores());
    }

    /**
     * Test get query scope of byName method
     *
     * @return void
     */
    public function testScopeGetByName()
    {
        $category = new Category;

        $this->assertEquals(new Collection, $category->byName('test')->get());
    }
}
