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

        $this->assertEquals(true, $crawl->checkIfCrawlable('example.com'));
    }

    public function testUrlNotCrawlable()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(false, $crawl->checkIfCrawlable('#'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('#example'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('javascript:void(0);'));
        $this->assertEquals(false, $crawl->checkIfCrawlable('javascript:executeSomeScripts();'));
        $this->assertEquals(false, $crawl->checkIfCrawlable(''));
    }

    public function testUrlIsExternalUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->setBaseUrl('http://example.com');
        $this->assertEquals('http://example.com/', $crawl->getBaseUrl());
        $this->assertEquals(true, $crawl->checkIfExternal('http://test.com'));
        $this->assertEquals(true, $crawl->checkIfExternal('https://test.com'));
    }

    public function testUrlIsNotExternalUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->setBaseUrl('example.com');
        $this->assertEquals(false, $crawl->checkIfExternal('http://example.com/test'));
        $this->assertEquals(false, $crawl->checkIfExternal('https://example.com/test'));
    }

    public function testGetEffectiveUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->getEffectiveUrl('http://example.com');
    }

    public function testDoRequestHtmlWithoutTag()
    {
        $html = '<!DOCTYPE html>
            <html>
                <body>
                    <p class="message">Hello World!</p>
                    <p>Hello Crawler!</p>
                </body>
            </html>';

        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');
        $stream = Mockery::mock('GuzzleHttp\Psr7\Stream');

        $client->shouldReceive('get')->andReturn($response);
        $domCrawler->shouldReceive('addHtmlContent')->with($html);
        $response->shouldReceive('getHeaderLine')->andReturn('http://example.com');
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('getBody')->andReturn($stream);
        $stream->shouldReceive('getContents')->andReturn($html);
        $stream->shouldReceive('close');
        
        $crawl = new CrawlerUrl($client, $domCrawler);
        $crawl->doRequest('http://example.com');
        $this->assertEquals([[
            'url' => 'http://example.com',
            'title' => '',
            'titleTag' => '',
            'desc' => '',
            'descTag' => '',
            'bodyContent' => gzdeflate($html, 9)
        ]], $crawl->getSiteUrl());
    }

    public function testDoRequestHtmlWithTag()
    {
        $html = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Example Domain</title>

                    <meta charset="utf-8" />
                    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                    <meta name="description" content="example description" />
                </head>
            </html>';

        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');
        $stream = Mockery::mock('GuzzleHttp\Psr7\Stream');

        $client->shouldReceive('get')->andReturn($response);
        $domCrawler->shouldReceive('addHtmlContent')->with($html);
        $domCrawler->shouldReceive('count')->andReturn(1);
        $domCrawler->shouldReceive('html')->andReturn($html);
        $response->shouldReceive('getHeaderLine')->andReturn('http://example.com');
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('getBody')->andReturn($stream);
        $stream->shouldReceive('getContents')->andReturn($html);
        $stream->shouldReceive('close');
        
        $crawl = new CrawlerUrl($client, $domCrawler);
        $crawl->doRequest('http://example.com');
        $this->assertEquals([[
            'url' => 'http://example.com',
            'title' => 'Example Domain',
            'titleTag' => '<title>Example Domain</title>',
            'desc' => 'example description',
            'descTag' => '<meta name="description" content="example description" />',
            'bodyContent' => gzdeflate($html, 9)
        ]], $crawl->getSiteUrl());
    }

    public function testDoRequestBrokenLink()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        $response->shouldReceive('getHeaderLine')->andReturn('http://example.com/test');
        $response->shouldReceive('getStatusCode')->andReturn(404);

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('http://example.com/test');

        $this->assertEquals(null, $result);
        $this->assertEquals(['http://example.com/test'], $crawl->getSiteBrokenLink());
    }

    public function testDoRequestCatchException()
    {
        $client = $this->getMockClientException();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('http://example.com/unknown');

        $this->assertEquals(null, $result);
    }

    public function testCheckNotInList()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $tempArraySiteList = $crawl->getSiteUrl();
        $result = $crawl->checkNotInList('http://example.com', $tempArraySiteList);

        $this->assertEquals(true, $result);
    }

    public function testCrawler()
    {
        $html = '<a href="http:example.com"></a>';

        $expectedResult = [
            [
                'url' => 'http://example.com',
                'title' => '',
                'titleTag' => '',
                'desc' => '',
                'descTag' => '',
                'bodyContent' => gzdeflate('', 9)
            ],
            [
                'url' => 'http://example.com/baz',
                'title' => '',
                'titleTag' => '',
                'desc' => '',
                'descTag' => '',
                'bodyContent' => gzdeflate('', 9)
            ],
            [
                'url' => 'http://example.com/test',
                'title' => '',
                'titleTag' => '',
                'desc' => '',
                'descTag' => '',
                'bodyContent' => gzdeflate('', 9)
            ],
        ];

        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response')->makePartial();

        $client->shouldReceive('get')->andReturn($response);
        $response->shouldReceive('getHeaderLine')->andReturn(
            'http://example.com',
            'http://example.com/test',
            'http://example.com/baz'
        );
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $domCrawler->shouldReceive('addHtmlContent')->andReturn($html);

        $crawling = new CrawlerUrl($client, $domCrawler);
        $crawling->setBaseUrl('http://example.com');
        $crawling->start();

        $this->assertEquals($expectedResult, $crawling->getSiteUrl());

        $this->assertEquals([], $crawling->getUnvisitedUrl());
    }

    public function testGetTitleAndDescTag()
    {
        $html = '<!DOCTYPE html>
            <html>
                <head>
                    <title>Example Domain</title>

                    <meta charset="utf-8" />
                    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                    <meta name="description" content="example description" />
                </head>
            </html>';
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(['', ''], $crawl->getTitleTag(''));
        $this->assertEquals(['<title>Example Domain</title>', 'Example Domain'], $crawl->getTitleTag($html));

        $this->assertEquals(['', ''], $crawl->getDescTag(''));
        $this->assertEquals([
            '<meta name="description" content="example description" />',
            'example description'], $crawl->getDescTag($html));
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
            'http://example.com',
            'http://example.com/test',
            'http://example.com/baz'
        ];

        $domCrawler = Mockery::mock(Crawler::class);
        $domCrawler->shouldReceive('filter')->andReturn($domCrawler);
        $domCrawler->shouldReceive('filterXPath')->andReturn($domCrawler);
        $domCrawler->shouldReceive('extract')->andReturn($links);

        return $domCrawler;
    }
}
