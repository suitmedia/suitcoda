<?php

namespace SuitTests\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Console\Commands\CrawlUrlCommand;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Console\Commands\CrawlUrlCommand
 */

class CrawlUrlCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test continue if user success save to database
     *
     * @return void
     */
    public function testCommand()
    {
        $this->artisan('crawl:url', [
            'url' => 'foobar.com'
        ]);
    }
}
