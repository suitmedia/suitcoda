<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Url;
use SuitTests\TestCase;

class UrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Url with Project
     *
     * @return void
     */
    public function testRelationshipWithProject()
    {
        $url = new Url;

        $this->assertInstanceOf(BelongsTo::class, $url->project());
    }

    /**
     * Test get query scope of byProjectId method
     *
     * @return void
     */
    public function testScopeByProjectId()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->byProjectId(1)->get());
    }

    /**
     * Test get query scope of byUrl method
     *
     * @return void
     */
    public function testScopeByUrl()
    {
        $url = new Url;

        $this->assertNull($url->byUrl('http://example.com')->get()->first());
    }

    /**
     * Test get query scope of active method
     *
     * @return void
     */
    public function testScopeActive()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->active()->get());
    }

    /**
     * Test get query scope of byType method
     *
     * @return void
     */
    public function testScopeByType()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->byType('url')->get());
    }
}
