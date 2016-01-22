<?php

namespace SuitTests\Supports;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Suitcoda\Supports\CrawlerUrl;
use Suitcoda\Supports\EffectiveUrlMiddleware;
use SuitTests\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerUrlTest extends TestCase
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
     * Test continue if url can be encode
     *
     * @return void
     */
    public function testEncodingUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals('http://example.com/', $crawl->encodeUrl('http://example.com/'));
        $this->assertEquals('http://example.com/test', $crawl->encodeUrl('http://example.com/test'));
        $this->assertEquals('http://example.com/test/', $crawl->encodeUrl('http://example.com/test/'));
        $this->assertEquals('http://example.com/test?q=123', $crawl->encodeUrl('http://example.com/test?q=123'));
        $this->assertEquals('http://example.com/test/page%3A1', $crawl->encodeUrl('http://example.com/test/page:1'));
        $this->assertEquals(
            'http://example.com/test/page%3A1?q=123',
            $crawl->encodeUrl('http://example.com/test/page:1?q=123')
        );
        $this->assertEquals(
            'http://example.com/test/page%3A1?q=123&s=456',
            $crawl->encodeUrl('http://example.com/test/page:1?q=123&s=456')
        );
        $this->assertEquals('/test', $crawl->encodeUrl('/test'));
        $this->assertEquals('/test?q=123', $crawl->encodeUrl('/test?q=123'));
        $this->assertEquals('/test?q=123/345', $crawl->encodeUrl('/test?q=123/345'));
        $this->assertEquals('/test/page%3A1', $crawl->encodeUrl('/test/page:1'));
        $this->assertEquals('test', $crawl->encodeUrl('test'));
        $this->assertEquals('test?q=123', $crawl->encodeUrl('test?q=123'));
        $this->assertEquals('test/page%3A1', $crawl->encodeUrl('test/page:1'));
        $this->assertEquals(
            'https://www.google.co.id/?q=https://suitmedia.com',
            $crawl->encodeUrl('https://www.google.co.id/?q=https://suitmedia.com')
        );
        $this->assertEquals('https://suitmedia.com/', $crawl->encodeUrl('https://suitmedia.com/'));
        $this->assertEquals('https://suitmedia.com/test', $crawl->encodeUrl('https://suitmedia.com/test'));
        $this->assertEquals('https://suitmedia.com/test/', $crawl->encodeUrl('https://suitmedia.com/test/'));
        $this->assertEquals(
            'https://suitmedia.com/test?q=123',
            $crawl->encodeUrl('https://suitmedia.com/test?q=123')
        );
        $this->assertEquals(
            'https://suitmedia.com/test/page%3A1',
            $crawl->encodeUrl('https://suitmedia.com/test/page:1')
        );
        $this->assertEquals(
            'https://suitmedia.com/test?q=http://pigeonteens.suitmedia.com',
            $crawl->encodeUrl('https://suitmedia.com/test?q=http://pigeonteens.suitmedia.com')
        );
    }

    /**
     * Test continue if js is from external assets
     *
     * @return void
     */
    public function testCheckExternalJs()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertTrue($crawl->checkExternalJs('http://example/assets/js/vendor/modernizer.js'));
        $this->assertTrue($crawl->checkExternalJs('http://example/assets/js/vendor/test.js'));
        $this->assertFalse($crawl->checkExternalJs('http://example/assets/js/main.js'));
    }

    /**
     * Test continue if url can be crawl
     *
     * @return void
     */
    public function testUrlCrawlable()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(true, $crawl->checkIfCrawlable('example.com'));
    }

    /**
     * Test continue if url not crawlable
     *
     * @return void
     */
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

    /**
     * Test continue if external url
     *
     * @return void
     */
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

    /**
     * Test continue if internal url
     *
     * @return void
     */
    public function testUrlIsNotExternalUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $crawl->setBaseUrl('example.com');
        $this->assertEquals(false, $crawl->checkIfExternal('http://example.com/test'));
        $this->assertEquals(false, $crawl->checkIfExternal('https://example.com/test'));
    }

    /**
     * Test continue if return Guzzle\Psr7\Response object
     *
     * @return void
     */
    public function testGetEffectiveUrl()
    {
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        $response = Mockery::mock('GuzzleHttp\Psr7\Response');

        $client->shouldReceive('get')->andReturn($response);
        
        $crawl = new CrawlerUrl($client, $domCrawler);

        $result = $crawl->getEffectiveUrl('http://example.com');

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Test continue if return url array of empty tag
     *
     * @return void
     */
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
            'type' => 'url',
            'url' => 'http://example.com',
            'title' => '',
            'titleTag' => '',
            'desc' => '',
            'descTag' => '',
            'bodyContent' => gzdeflate($html),
            'depth' => 0
        ]], $crawl->getSiteUrl());
    }

    /**
     * Test continue if return array of url full info
     *
     * @return void
     */
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
            'type' => 'url',
            'url' => 'http://example.com',
            'title' => 'Example Domain',
            'titleTag' => '<title>Example Domain</title>',
            'desc' => 'example description',
            'descTag' => '<meta name="description" content="example description" />',
            'bodyContent' => gzdeflate($html),
            'depth' => 0
        ]], $crawl->getSiteUrl());
    }

    /**
     * Test continue if return array of broken link
     *
     * @return void
     */
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

    /**
     * Test continue if return null on doRequest
     *
     * @return void
     */
    public function testDoRequestCatchException()
    {
        $client = $this->getMockClientException();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('http://example.com/unknown');

        $this->assertEquals(null, $result);
    }

    /**
     * Test continue if url still not in array
     *
     * @return void
     */
    public function testCheckNotInList()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $tempArraySiteList = $crawl->getSiteUrl();
        $result = $crawl->checkNotInList('http://example.com', $tempArraySiteList);

        $this->assertEquals(true, $result);
    }

    /**
     * Test continue if expected url
     *
     * @return void
     */
    public function testCrawler()
    {
        $html = '<a href="http:example.com"></a>';

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

        $this->assertEquals([], $crawling->getSiteUrl());

        $this->assertEquals([], $crawling->getUnvisitedUrl());
    }

    /**
     * Test continue if return expected tag
     *
     * @return void
     */
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

    /**
     * Test continue if return js or css extension
     *
     * @return void
     */
    public function testGetExtension()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $this->assertEquals('css', $crawl->getExtension('http://example.com/main.min.css'));
        $this->assertEquals('css', $crawl->getExtension('http://example.com/main.min.css?dt=21312435646'));
        $this->assertEquals('css', $crawl->getExtension('http://example.com/main.min.css?123456789'));

        $this->assertEquals('js', $crawl->getExtension('http://example.com/main.min.js'));
        $this->assertEquals('js', $crawl->getExtension('http://example.com/main.min.js?dt=21312435646'));
        $this->assertEquals('js', $crawl->getExtension('http://example.com/main.min.js?123456789'));

        $this->assertEquals(null, $crawl->getExtension('http://example.com'));
    }

    /**
     * Test continue if return expected url depth
     *
     * @return void
     */
    public function testGetUrlDepth()
    {
        $client = $this->getMockClient();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);

        $this->assertEquals(0, $crawl->getUrlDepth('http://example.com'));
        $this->assertEquals(0, $crawl->getUrlDepth('http://example.com/'));
        $this->assertEquals(0, $crawl->getUrlDepth('http://example.com?q=user-1&s=user_2'));
        $this->assertEquals(0, $crawl->getUrlDepth('http://example.com/?q=user-1&s=user_2'));
        $this->assertEquals(0, $crawl->getUrlDepth('http://example.com/#about-us'));
        $this->assertEquals(3, $crawl->getUrlDepth('http://example.com/test/foo/bar/'));
        $this->assertEquals(3, $crawl->getUrlDepth('http://example.com/test/foo/bar?q=user-1&s=user_2'));
        $this->assertEquals(3, $crawl->getUrlDepth('http://example.com/test/foo/bar/?q=user-1&s=user_2'));
        $this->assertEquals(3, $crawl->getUrlDepth('http://example.com/test/foo/bar/#about-us'));
    }

    /**
     * Test continue if return empty array
     *
     * @return void
     */
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

    /**
     * Test continue if return null
     *
     * @return void
     */
    public function testDoRequestWithImgContentType()
    {
        $client = new Client();
        $domCrawler = $this->getMockDomCrawler()->makePartial();

        $crawl = new CrawlerUrl($client, $domCrawler);
        $result = $crawl->doRequest('https://www.google.co.id/images/branding/product/ico/googleg_lodp.ico');

        $this->assertNull($result);
    }

    /**
     * Test getAllLink with external url
     *
     * @return void
     */
    public function testGetAllLinkInExternalJs()
    {
        $array = [];
        $url = 'http://example.com';
        $client = $this->getMockClient()->makePartial();
        $domCrawler = $this->getMockDomCrawler()->makePartial();
        
        $crawl = Mockery::mock(
            CrawlerUrl::class . '[encodeUrl, checkIfExternal, checkNotInList, checkExternalJs]',
            [$client, $domCrawler]
        );

        $crawl->shouldReceive('encodeUrl')->andReturn($url);
        $crawl->shouldReceive('checkIfExternal')->andReturn(true);
        $crawl->shouldReceive('checkNotInList')->andReturn(true);
        $crawl->shouldReceive('checkExternalJs')->andReturn(true);

        $crawl->getAllLink($url, ['a', 'b'], $array);
    }

    /**
     * Get Mock Guzzle Client for Throwing Exception
     *
     * @return GuzzleHttp\Client
     */
    protected function getMockClientException()
    {
        $client = $this->getMockClient()->makePartial();

        $client->shouldReceive('get')->times(4)->andThrow(new \Exception);
        
        return $client;
    }

    /**
     * Get Mock Guzzle Client
     *
     * @return GuzzleHttp\Client
     */
    protected function getMockClient()
    {
        $client = Mockery::mock(Client::class);

        return $client;
    }

    /**
     * Get Mock Symfony Dom Crawler
     *
     * @return Symfony\Component\DomCrawler\Crawler
     */
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
