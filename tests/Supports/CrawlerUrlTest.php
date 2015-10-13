<?php

namespace SuitTests\Supports;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Supports\CrawlerUrl;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\HandlerStack;
use Suitcoda\Supports\EffectiveUrlMiddleware;

class CrawlerUrlTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testUrlCrawlable()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(true, $crawl->checkIfCrawlable('foobar.com'));
    }

    public function testUrlNotCrawlable()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(false, $crawl->checkIfCrawlable('#'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('#foobar'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('javascript:void(0);'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('javascript:executeSomeScripts();'));
        $this->assertEquals(false, $crawl->checkIfCrawlable(''));
    }

    public function testUrlIsExternalUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->setBaseUrl('http://foobar.com');
        $this->assertEquals('http://foobar.com/', $crawl->getBaseUrl());
        $this->assertEquals(true, $crawl->checkIfExternal('http://test.com'));
        $this->assertEquals(true, $crawl->checkIfExternal('https://test.com'));
    }

    public function testUrlIsNotExternalUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->setBaseUrl('foobar.com');
        $this->assertEquals(false, $crawl->checkIfExternal('http://foobar.com/test'));
        $this->assertEquals(false, $crawl->checkIfExternal('https://foobar.com/test'));
    }

    public function testGetEffectiveUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->getEffectiveUrl('http://foobar.com');
    }

    public function testDoRequestHtml()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        $response->shouldReceive('getHeaderLine')->andReturn('http://foobar.com');
        $response->shouldReceive('getStatusCode')->andReturn(200);
        
        $crawl = new CrawlerUrl($client, $domCrawler);
        $crawl->doRequest('http://foobar.com');

        $this->assertEquals(['http://foobar.com'], $crawl->getSiteUrl());
    }

    public function testDoRequestBrokenLink()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        $response->shouldReceive('getHeaderLine')->andReturn('http://foobar.com/test');
        $response->shouldReceive('getStatusCode')->andReturn(404);

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('http://foobar.com/test');

        $this->assertEquals(null, $result);
        $this->assertEquals(['http://foobar.com/test'], $crawl->getSiteBrokenLink());
    }

    public function testDoRequestCatchException()
    {
        $client = $this->getMockClientException();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('http://foobar.com/unknown');

        $this->assertEquals(null, $result);
    }

    public function testCheckNotInList()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $tempArraySiteList = $crawl->getSiteUrl();
        $result = $crawl->checkNotInList('http://foobar.com', $tempArraySiteList);

        $this->assertEquals(true, $result);
    }

    public function testCrawler()
    {
        $html = '<a href="http:foobar.com"></a>';

        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response')->makePartial();

        $client->shouldReceive('get')->andReturn($response);
        $response->shouldReceive('getHeaderLine')->andReturn(
            'http://foobar.com',
            'http://foobar.com/test',
            'http://foobar.com/baz'
        );
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $domCrawler->shouldReceive('addHtmlContent')->andReturn($html);

        $crawling = new CrawlerUrl($client, $domCrawler);
        $crawling->setBaseUrl('http://foobar.com');
        $crawling->start();

        $this->assertEquals([
            'http://foobar.com',
            'http://foobar.com/baz',
            'http://foobar.com/test'
        ], $crawling->getSiteUrl());
    }

    public function testDumpGet()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals([], $crawl->getSiteCss());
        $this->assertEquals([], $crawl->getSiteJs());
        $this->assertEquals([], $crawl->getSiteBrokenLink());
        $this->assertEquals([], $crawl->getSiteRedirectUrl());
    }

    protected function getMockClientException()
    {
        $client = $this->getMockClient()->makePartial();

        $client->shouldReceive('get')->times(4)->andThrow(new \RuntimeException);

        return $client;
    }

    protected function getMockClient()
    {
        $client = Mockery::mock(Client::class);

        return $client;
    }

    protected function getMockStatusCodeSuccess()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getStatus')->andReturn(200);

        return $response;
    }

    protected function getMockStatusCodeFailed()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getStatus')->andReturn(404);

        return $response;
    }

    protected function getMockDomCrawler()
    {
        $links = [
            'http://foobar.com',
            'http://foobar.com/test',
            'http://foobar.com/baz'
        ];

        $domCrawler = Mockery::mock(Crawler::class);
        $domCrawler->shouldReceive('filter')->andReturn($domCrawler);
        $domCrawler->shouldReceive('filterXPath')->andReturn($domCrawler);
        $domCrawler->shouldReceive('extract')->andReturn($links);

        return $domCrawler;
    }
}
