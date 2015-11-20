<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Url;

class UrlTest extends TestCase
{
    use DatabaseTransactions;

    public function testRelationshipWithProject()
    {
        $url = new Url;

        $this->assertInstanceOf(BelongsTo::class, $url->project());
    }

    public function testScopeByProjectId()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->byProjectId(1)->get());
    }

    public function testScopeByUrl()
    {
        $url = new Url;

        $this->assertNull($url->byUrl('http://example.com')->get()->first());
    }

    public function testScopeActive()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->active()->get());
    }

    public function testScopeByType()
    {
        $url = new Url;

        $this->assertEquals(new Collection, $url->byType('url')->get());
    }
}
