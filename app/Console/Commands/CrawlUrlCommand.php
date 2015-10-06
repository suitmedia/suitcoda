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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Client $client, Crawler $crawler)
    {
        $url = $this->argument('url');
        $crawlCommand = new CrawlerUrl($client, $crawler);
        $crawlCommand->setBaseUrl($url);
        $crawlCommand->start();

        print_r($crawlCommand->getSiteUrl());
        print_r($crawlCommand->getSiteCss());
        print_r($crawlCommand->getSiteJs());
        print_r($crawlCommand->getSiteBrokenLink());
        print_r($crawlCommand->getSiteFile());
        print_r($crawlCommand->getSiteRedirectLink());
    }
}
