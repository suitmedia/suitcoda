<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Supports\CrawlerUrl;
// use Goutte\Client;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CrawlUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:url {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawling urls a website.';

    protected $client;

    protected $crawler;

    /**
     * Create a new command instance.
     *
     * @param GuzzleHttp\Client $client []
     * @param Symfony\Component\DomCrawler\Crawler $crawler []
     */
    public function __construct(Client $client, Crawler $crawler)
    {
        parent::__construct();
        $this->client = $client;
        $this->crawler = $crawler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (is_string($this->argument('url'))) {
            $url = $this->argument('url');
            $crawlCommand = new CrawlerUrl($this->client, $this->crawler);
            $crawlCommand->setBaseUrl($url);
            $crawlCommand->start();
        }
    }
}
