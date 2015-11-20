<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Scope;

class ScopeTest extends TestCase
{
    use DatabaseTransactions;

    public function testRelationshipWithSubScopes()
    {
        $scope = new Scope;

        $this->assertInstanceOf(HasMany::class, $scope->subScopes());
    }

    public function testRelationshipWithCommand()
    {
        $scope = new Scope;

        $this->assertInstanceOf(HasOne::class, $scope->command());
    }

    public function testScopeGetByName()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Scope::class, $scope->getByName('seo'));
    }

    public function testScopeByType()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Collection::class, $scope->byType('url')->get());
    }

    public function testScopeByCategory()
    {
        $scope = new Scope;

        $this->assertInstanceOf(Collection::class, $scope->byCategory('SEO')->get());
    }
}
