<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Category;
use SuitTests\TestCase;

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
}
