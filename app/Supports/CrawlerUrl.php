<?php

namespace Suitcoda\Supports;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Sabre\Uri;
use Suitcoda\Supports\EffectiveUrlMiddleware;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerUrl
{
    /**
     * Stores the base url of current crawling session
     *
     * @var string
     */
    protected $baseUrl;
    /**
     * Guzzle Http Client
     *
     * @var Object
     */
    protected $client;
    /**
     * Symfony DOM Crawler
     *
     * @var Object
     */
    protected $crawler;
    /**
     * Maximum attempt to retry on any unsuccessful request
     *
     * @var integer
     */
    protected $retry = 3;
    /**
     * List of Broken links
     *
     * @var array
     */
    protected $siteBrokenLink;
    /**
     * List of Css
     *
     * @var array
     */
    protected $siteCss;
    /**
     * List of Javascript
     *
     * @var array
     */
    protected $siteJs;
    /**
     * List of redirected url
     *
     * @var array
     */
    public $siteRedirectLink;
    /**
     * List of html url
     *
     * @var array
     */
    protected $siteUrl;
    /**
     * List of unvisited url
     *
     * @var array
     */
    public $unvisitedUrl;
    /**
     * Class constructor
     *
     * @param Client  $client  [Guzzle HTTP Client]
     * @param Crawler $crawler [Symfony DOM Crawler]
     */
    public function __construct(Client $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
        
        $this->siteBrokenLink = [];
        $this->siteCss = [];
        $this->siteJs = [];
        $this->siteRedirectLink = [];
        $this->siteUrl = [];
        $this->unvisitedUrl = [];
    }
    /**
     * Get list of url from the web
     *
     * @return array
     */
    public function getSiteUrl()
    {
        sort($this->siteUrl);
        return $this->siteUrl;
    }
    /**
     * Get list of css from the web
     *
     * @return array
     */
    public function getSiteCss()
    {
        return $this->siteCss;
    }
    /**
     * Get list of js from the web
     *
     * @return array
     */
    public function getSiteJs()
    {
        return $this->siteJs;
    }
    /**
     * Get list of broken links
     *
     * @return int
     */
    public function getSiteBrokenLink()
    {
        return $this->siteBrokenLink;
    }
    /**
     * Set website url for crawling
     *
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        if (strpos($baseUrl, 'http') === false) {
            $this->baseUrl = Uri\normalize('http://' . $baseUrl);
        } else {
            $this->baseUrl = Uri\normalize($baseUrl);
        }
    }
    /**
     * Get main url of website
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /**
     * Check url is crawlable or not
     *
     * @param  string $url
     * @return boolean
     */
    public function checkIfCrawlable($url)
    {
        if (empty($url)) {
            return false;
        }
        $patterns = array(
            '@^javascript\:@',
            '@^#.*@',
            '@^void\(0\);$@'
        );
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return false;
            }
        }
        return true;
    }
    /**
     * Check url is external url or not
     *
     * @param  string $url
     * @return boolean
     */
    public function checkIfExternal($url)
    {
        $baseUrlTrimmed = str_replace(array('http://', 'https://'), '', $this->baseUrl);
        if (preg_match("@http(s)?\://$baseUrlTrimmed@", $url)) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Checking a url in the array of site that crawl or not
     *
     * @param  string $url
     * @param  array &$siteLink
     * @return boolean
     */
    public function checkNotInList($url, &$siteLink)
    {
        if (!in_array($url, $siteLink) &&
            !in_array($url, $this->siteBrokenLink) &&
            !in_array($url, $this->siteRedirectLink)) {
            return true;
        }
        return false;
    }
    
    /**
     * Function to trigger start crawling a website
     *
     * @return void
     */
    public function start()
    {
        $this->unvisitedUrl[] = $this->baseUrl;
        while ((count($this->unvisitedUrl) > 0) && ($url = array_shift($this->unvisitedUrl))) {
            $this->crawl($url);
        }
    }
    /**
     * Function to filter a url base on html tag
     *
     * @param  string $url
     */
    protected function crawl($url)
    {
        $responseUrl = $this->doRequest($url);
        if (!is_null($responseUrl)) {
            $this->crawler->addHtmlContent($responseUrl->getBody()->getContents());
            
            $listCss = $this->crawler->filterXPath('//*[@rel="stylesheet"]')->extract('href');
            $this->getAllLink($url, $listCss, $this->siteCss);
            $listJs = $this->crawler->filter('script')->extract('src');
            $this->getAllLink($url, $listJs, $this->siteJs);
            $listUrl = $this->crawler->filter('a')->extract('href');
            $this->getAllLink($url, $listUrl, $this->siteUrl, 1);
        }
        $this->crawler->clear();
        unset($responseUrl);
    }
    /**
     * Function to get all link url, css and js from a url
     *
     * @param  array  $lists
     * @param  array  &$siteLink
     * @param  integer $recursive
     */
    protected function getAllLink($currentUrl, $lists, &$siteLink, $recursive = 0)
    {
        foreach ($lists as $list) {
            if (!$list || !$this->checkIfCrawlable($list)) {
                continue;
            }
            
            $list = preg_replace('/(\.\.\/)+/', '/', $list);
            $list = Uri\resolve($currentUrl, $list);
            if ($this->checkIfExternal($list) || !$this->checkNotInList($list, $siteLink)) {
                continue;
            }
            if (!$recursive) {
                array_push($siteLink, $list);
            } elseif (!in_array($list, $this->unvisitedUrl)) {
                $this->unvisitedUrl[] = $list;
            }
        }
    }
    /**
     * Function to checking and retrying a url
     *
     * @param  string $url
     * @param  int $try
     */
    public function doRequest($url, $try = null)
    {
        if (is_null($try)) {
            $try = $this->retry;
        }
        if ($try < 0) {
            return null;
        }
        try {
            $responseUrl = $this->getEffectiveUrl($url);
            $effectiveUrl = $responseUrl->getHeaderLine('X-GUZZLE-EFFECTIVE-URL');
            if ($responseUrl->getStatusCode() === 200 &&
                $this->checkNotInList($effectiveUrl, $this->siteUrl)) {
                array_push($this->siteUrl, $effectiveUrl);
                return $responseUrl;
            }
            if ($responseUrl->getStatusCode() >= 400) {
                array_push($this->siteBrokenLink, $effectiveUrl);
                return null;
            }
            array_push($this->siteRedirectLink, $url);
            return null;
        } catch (\Exception $e) {
            $try--;
            return $this->doRequest($url, $try);
        }
    }
    /**
     * Get the last redirect from a url
     *
     * @param  string $url
     * @return string
     */
    public function getEffectiveUrl($url)
    {
        $stack = HandlerStack::create();
        $stack->push(EffectiveUrlMiddleware::middleware());
        $response = $this->client->get($url, [
            'handler' => $stack,
            'http_errors' => false,
            'on_headers' => function (\Psr\Http\Message\ResponseInterface $response) {
                if (strpos($response->getHeaderLine('Content-Type'), 'text/html') === false) {
                    throw new \Exception;
                }
            }
        ]);
        return $response;
    }
}
