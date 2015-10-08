<?php

namespace Suitcoda\Supports;

// use Goutte\Client;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Symfony\Component\DomCrawler\Crawler;
use Suitcoda\Supports\EffectiveUrlMiddleware;
use Sabre\Uri;

class CrawlerUrl
{
    protected $retry = 3;

    protected $baseUrl;

    protected $siteUrl;

    protected $siteJs;

    protected $siteCss;

    protected $siteBrokenLink;

    protected $siteRedirectLink;

    protected $contentType;

    protected $crawler;

    public function __construct(Client $client, Crawler $crawler)
    {
        $this->siteUrl = array();
        $this->siteJs = array();
        $this->siteCss = array();
        $this->linkToCrawl = array();
        $this->siteBrokenLink = array();
        $this->siteRedirectLink = array();

        $this->client = $client;
        $this->crawler = $crawler;
    }

    /**
     * Get list of url from the web
     * @return array
     */
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    /**
     * Get list of css from the web
     * @return array
     */
    public function getSiteCss()
    {
        return $this->siteCss;
    }

    /**
     * Get list of js from the web
     * @return array
     */
    public function getSiteJs()
    {
        return $this->siteJs;
    }

    /**
     * Get list of broken links
     * @return int
     */
    public function getSiteBrokenLink()
    {
        return $this->siteBrokenLink;
    }

    /**
     * Set website url for crawling
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
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Check url is crawlable or not
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
     * @return void
     */
    public function start()
    {
        $this->crawl($this->baseUrl);
    }

    /**
     * Function to filter a url base on html tag
     * @param  string $url
     */
    protected function crawl($url)
    {
        $responseUrl = $this->doRequest($url);
        if (!is_null($responseUrl)) {
            $domCrawler = $this->crawler;
            $domCrawler->addHtmlContent($responseUrl->getBody()->getContents());
            
            $listCss = $domCrawler->filterXPath('//*[@rel="stylesheet"]')->extract('href');
            $this->getAllLink($url, $listCss, $this->siteCss);

            $listJs = $domCrawler->filter('script')->extract('src');
            $this->getAllLink($url, $listJs, $this->siteJs);

            $listUrl = $domCrawler->filter('a')->extract('href');
            $this->getAllLink($url, $listUrl, $this->siteUrl, 1);
        }
    }

    /**
     * Function to get all link url, css and js from a url
     * @param  array  $lists
     * @param  array  &$siteLink
     * @param  integer $recursive
     */
    protected function getAllLink($currentUrl, $lists, &$siteLink, $recursive = 0)
    {
        foreach ($lists as $list) {
            if (!is_null($list) && $this->checkIfCrawlable($list)) {
                $list = Uri\resolve($currentUrl, $list);
                if ($this->checkNotInList($list, $siteLink) && !$this->checkIfExternal($list)) {
                    if (!$recursive) {
                            array_push($siteLink, $list);
                    } else {
                        $this->crawl($list);
                    }
                }
            }
        }
    }

    /**
     * Function to checking and retrying a url
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
                echo $effectiveUrl . " : " . count($this->siteUrl) . "\n";
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
