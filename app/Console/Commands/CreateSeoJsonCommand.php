<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Supports\SeoBackProcess;

class CreateSeoJsonCommand extends Command
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

    protected $seo;

    /**
     * Create a new command instance.
     *
     * @param Suitcoda\Supports\SeoBackProcess $seo []
     * @return void
     */
    public function __construct(SeoBackProcess $seo)
    {
        parent::__construct();
        $this->seo = $seo;
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
        $this->seo->setUrl($url);
        $this->seo->setDestination($destination);
        $this->seo->setOption($option);
        $this->seo->run();
    }
}
