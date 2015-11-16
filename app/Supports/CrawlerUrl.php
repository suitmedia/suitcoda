<?php

namespace Suitcoda\Supports;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Sabre\Uri;
use Suitcoda\Exceptions\HtmlContentTypeException;
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
    protected $siteRedirectLink;

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
    protected $unvisitedUrl;

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
     * @return array
     */
    public function getSiteBrokenLink()
    {
        return $this->siteBrokenLink;
    }

    /**
     * Get list of redirected url
     *
     * @return array
     */
    public function getSiteRedirectUrl()
    {
        return $this->siteRedirectLink;
    }

    /**
     * Get list of unvisited url
     * @return array
     */
    public function getUnvisitedUrl()
    {
        return $this->unvisitedUrl;
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
        if (!in_array($url, array_pluck($siteLink, 'url')) &&
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
                array_push($siteLink, ['type' => $this->getExtension($list), 'url' => $list]);
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
                $bodyContent = $responseUrl->getBody()->getContents();
                $compressedBodyContent = gzdeflate($bodyContent, 9);
                $this->crawler->addHtmlContent($bodyContent);
                unset($bodyContent);
                if ($this->crawler->filterXPath('//head')->count() &&
                    !empty($this->crawler->filterXPath('//head')->html())) {
                    $headTag = $this->crawler->filterXPath('//head')->html();
                    
                    $titleTag = $this->getTitleTag($headTag);
                    $descTag = $this->getDescTag($headTag);
                    array_push($this->siteUrl, [
                        'type' => 'url',
                        'url' => $effectiveUrl,
                        'title' => $titleTag[1],
                        'titleTag' => $titleTag[0],
                        'desc' => $descTag[1],
                        'descTag' => $descTag[0],
                        'bodyContent' => $compressedBodyContent
                    ]);
                } else {
                    array_push($this->siteUrl, [
                        'type' => 'url',
                        'url' => $effectiveUrl,
                        'title' => '',
                        'titleTag' => '',
                        'desc' => '',
                        'descTag' => '',
                        'bodyContent' => $compressedBodyContent
                    ]);
                }
                unset($compressedBodyContent);

                return $responseUrl;
            }
            if ($responseUrl->getStatusCode() >= 400) {
                array_push($this->siteBrokenLink, $effectiveUrl);
                return null;
            }
            array_push($this->siteRedirectLink, $url);
            return null;
        } catch (\Exception $e) {
            if (!($e->getPrevious() instanceof HtmlContentTypeException)) {
                $try--;
                return $this->doRequest($url, $try);
            }
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
                    throw new HtmlContentTypeException;
                }
            }
        ]);
        return $response;
    }

    /**
     * Get the title tag and content of tag
     *
     * @param  string $html
     * @return array
     */
    public function getTitleTag($html)
    {
        $titleTag = preg_match(
            '/<title[^>]*>([\s\S]*?)<\/title>/',
            $html,
            $titleTagMatches
        );
        if (empty($titleTagMatches)) {
            $finalTitleTagMatches = ['', ''];
        } else {
            $finalTitleTagMatches[] = $titleTagMatches[0];
            $finalTitleTagMatches[] = trim($titleTagMatches[1]);
        }
        return $finalTitleTagMatches;
    }

    /**
     * Get the meta tag description and content of tag
     *
     * @param  string $html
     * @return array
     */
    public function getDescTag($html)
    {
        $descTag = preg_match(
            '/<meta name="description"(.*?)content="(.*?)"(.*?\/*)>/',
            $html,
            $descTagMatches
        );
        if (empty($descTagMatches)) {
            $finalDescTagMatches = ['', ''];
        } else {
            $finalDescTagMatches[] = $descTagMatches[0];
            $finalDescTagMatches[] = trim($descTagMatches[2]);
        }
        return $finalDescTagMatches;
    }

    public function getExtension($url)
    {
        $extensions = [
            'css',
            'js'
        ];

        foreach ($extensions as $ext) {
            if (str_contains(pathinfo($url, PATHINFO_EXTENSION), $ext)) {
                return $ext;
            }
        }
        return null;
    }
}
