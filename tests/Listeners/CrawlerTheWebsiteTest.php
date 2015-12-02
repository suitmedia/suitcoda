<?php

namespace SuitTests\Listeners;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Listeners\CrawlerTheWebsite;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\CrawlerUrl;
use SuitTests\TestCase;

class CrawlerTheWebsiteTest extends TestCase
{
    use DatabaseTransactions;

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
     * Test handle with active url
     *
     * @return void
     */
    public function testHandleWithDatabaseActiveUrl()
    {
        $urlFaker = factory(Url::class, 5)->create();

        $project = Mockery::mock(Project::class)->makePartial();
        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $crawler = Mockery::mock(CrawlerUrl::class)->shouldIgnoreMissing();
        $url = Mockery::mock(Url::class)->makePartial();
        $relation = Mockery::mock(HasMany::class)->shouldIgnoreMissing();

        $project->shouldReceive('getAttribute')->andReturn($urlFaker);
        $project->shouldReceive('urls')->andReturn($relation);
        $url->shouldReceive('newInstance')->andReturn($url);
        $crawler->shouldReceive('getSiteUrl')->andReturn([
            [
                'type' => 'url',
                'url' => 'http://example.com',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'url' => 0
            ],
            [
                'type' => 'url',
                'url' => 'http://example.com/test',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'depth' => 1
            ]
        ]);
        $crawler->shouldReceive('getSiteCss')->andReturn([
            [
                'type' => 'css',
                'url' => 'http://example.com/main.css',
            ]
        ]);
        $crawler->shouldReceive('getSiteJs')->andReturn([
            [
                'type' => 'js',
                'url' => 'http://example.com/main.js',
            ]
        ]);

        $listener = new CrawlerTheWebsite($crawler, $url);
        $listener->handle(new ProjectWatcher($project, $inspection));
    }

    /**
     * Test handle with deactive url
     *
     * @return void
     */
    public function testHandleWithDatabaseNotActiveUrl()
    {
        $urlFaker = factory(Url::class, 5)->create();

        $project = Mockery::mock(Project::class)->makePartial();
        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $crawler = Mockery::mock(CrawlerUrl::class)->shouldIgnoreMissing();
        $url = Mockery::mock(Url::class)->makePartial();
        $relation = Mockery::mock(HasMany::class)->shouldIgnoreMissing();

        $project->shouldReceive('getAttribute')->andReturn($urlFaker);
        $project->shouldReceive('urls')->andReturn($relation);
        $url->shouldReceive('newInstance')->andReturn($url);
        $crawler->shouldReceive('getSiteUrl')->andReturn([
            [
                'type' => 'url',
                'url' => 'http://example.com',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'depth' => 0
            ],
            [
                'type' => 'url',
                'url' => 'http://example.com/foo',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'depth' => 1
            ]
        ]);
        $crawler->shouldReceive('getSiteCss')->andReturn([
            [
                'type' => 'css',
                'url' => 'http://example.com/main.css',
            ]
        ]);
        $crawler->shouldReceive('getSiteJs')->andReturn([
            [
                'type' => 'js',
                'url' => 'http://example.com/main.js',
            ]
        ]);

        $listener = new CrawlerTheWebsite($crawler, $url);
        $listener->handle(new ProjectWatcher($project, $inspection));
    }

    /**
     * Test handle with empty database
     *
     * @return void
     */
    public function testHandleWithEmptyDatabase()
    {
        $project = Mockery::mock(Project::class)->makePartial();
        $inspection = Mockery::mock(Inspection::class)->makePartial();
        $crawler = Mockery::mock(CrawlerUrl::class)->shouldIgnoreMissing();
        $url = Mockery::mock(Url::class)->makePartial();
        $relation = Mockery::mock(HasMany::class)->shouldIgnoreMissing();

        $project->shouldReceive('getAttribute')->andReturn(new Collection);
        $project->shouldReceive('urls')->andReturn($relation);
        $url->shouldReceive('newInstance')->andReturn($url);
        $crawler->shouldReceive('getSiteUrl')->andReturn([
            [
                'type' => 'url',
                'url' => 'http://example.com',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'depth' => 0
            ],
            [
                'type' => 'url',
                'url' => 'http://example.com/test',
                'title' => 'Example Domain',
                'titleTag' => '<title>Example Domain</title>',
                'desc' => 'example description',
                'descTag' => '<meta name="description" content="example description" />',
                'bodyContent' => '',
                'depth' => 1
            ]
        ]);
        $crawler->shouldReceive('getSiteCss')->andReturn([
            [
                'type' => 'css',
                'url' => 'http://example.com/main.css',
            ]
        ]);
        $crawler->shouldReceive('getSiteJs')->andReturn([
            [
                'type' => 'js',
                'url' => 'http://example.com/main.js',
            ]
        ]);

        $listener = new CrawlerTheWebsite($crawler, $url);
        $listener->handle(new ProjectWatcher($project, $inspection));
    }
}
