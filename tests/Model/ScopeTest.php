<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Scope;
use SuitTests\TestCase;

class ScopeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Scope with SubScope
     *
     * @return void
     */
    public function testRelationshipWithSubScopes()
    {
        $scope = new Scope;

        $this->assertInstanceOf(HasMany::class, $scope->subScopes());
    }

    /**
     * Test Relationship Scope with Issues
     *
     * @return void
     */
    public function testRelationshipWithIssues()
    {
        $scope = new Scope;

        $this->assertInstanceOf(HasMany::class, $scope->issues());
    }

    /**
     * Test Relationship Scope with Command
     *
     * @return void
     */
    public function testRelationshipWithCommand()
    {
        $scope = new Scope;

        $this->assertInstanceOf(HasOne::class, $scope->command());
    }

    /**
     * Test get query scope of getByName method
     *
     * @return void
     */
    public function testScopeGetByName()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Scope::class, $scope->getByName('seo'));
    }

    /**
     * Test get query scope of byType method
     *
     * @return void
     */
    public function testScopeByType()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Collection::class, $scope->byType('url')->get());
    }

    /**
     * Test get query scope of byCategory method
     *
     * @return void
     */
    public function testScopeByCategory()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Collection::class, $scope->byCategory('SEO')->get());
    }
}
