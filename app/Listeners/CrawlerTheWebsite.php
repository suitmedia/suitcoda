<?php

namespace Suitcoda\Listeners;

use Suitcoda\Events\ProjectWatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Suitcoda\Supports\CrawlerUrl;
use Suitcoda\Model\Url;

class CrawlerTheWebsite implements ShouldQueue
{
    protected $crawler;

    protected $url;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CrawlerUrl $crawler, Url $url)
    {
        $this->crawler = $crawler;
        $this->url = $url;
    }

    /**
     * Handle the event.
     *
     * @param  ProjectWatcher  $event
     * @return void
     */
    public function handle(ProjectWatcher $event)
    {
        $urlsFromDatabase = $event->project->urls->pluck('url');
        if (is_string($urlsFromDatabase)) {
            $urlsFromDatabase = (array)$urlsFromDatabase;
        } else {
            $urlsFromDatabase = $urlsFromDatabase->toArray();
        }
        $this->crawler->setBaseUrl($event->project->main_url);
        $this->crawler->start();
        $urlsFromWeb = array_merge(
            $this->crawler->getSiteUrl(),
            $this->crawler->getSiteCss(),
            $this->crawler->getSiteJs()
        );
        if (empty($urlsFromDatabase)) {
            foreach ($urlsFromWeb as $url) {
                $this->addNewUrl($event, $url);
            }
        } else {
            foreach ($urlsFromWeb as $url) {
                if (!in_array($url['url'], $urlsFromDatabase)) {
                    $this->addNewUrl($event, $url);
                }
            }
            foreach ($urlsFromDatabase as $url) {
                $objectUrl = Url::ByUrl($url)->first();
                if (!in_array($url, array_pluck($urlsFromWeb, 'url'))) {
                    $objectUrl->update(['is_active' => false]);
                } else {
                    $objectUrl->update(['is_active' => true]);
                }
            }
        }

        $event->project->update(['is_crawlable' => false]);
    }

    protected function addNewUrl($event, $url)
    {
        $model = $this->url->newInstance();
        $model->type = $url['type'];
        $model->url = $url['url'];
        if (strcmp($url['type'], 'url') == 0) {
            $model->depth = 2; //temp
            $model->title = $url['title'];
            $model->title_tag = $url['titleTag'];
            $model->desc = $url['desc'];
            $model->desc_tag = $url['descTag'];
            $model->body_content = $url['bodyContent'];
        }
        $model->is_active = true;
        $event->project->urls()->save($model);
    }
}
