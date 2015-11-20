<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Supports\BackendSeoChecker;

class BackendSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checker:backend-seo {--url} {url} {--destination} {destination}
        {--title-similar} {--desc-similar} {--depth}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check run seo title, description and url depth.';

    protected $checker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BackendSeoChecker $checker)
    {
        parent::__construct();
        $this->checker = $checker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = $this->option();
        $url = $this->argument('url');
        $destination = $this->argument('destination');
        $this->checker->setUrl($url);
        $this->checker->setDestination($destination);
        $this->checker->setOption($option);
        $this->checker->run();
    }
}
