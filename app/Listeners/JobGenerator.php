<?php

namespace Suitcoda\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Model\JobInspect;
use Suitcoda\Supports\ScopesCheckerGenerator;

class JobGenerator implements ShouldQueue
{
    protected $generator;

    protected $job;

    protected $typeList = [
        'url',
        'css',
        'js'
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ScopesCheckerGenerator $generator, JobInspect $job)
    {
        $this->generator = $generator;
        $this->job = $job;
    }

    /**
     * Handle the event.
     *
     * @param  ProjectWatcher  $event
     * @return void
     */
    public function handle(ProjectWatcher $event)
    {
        foreach ($this->typeList as $type) {
            $this->generateJobByType($event, $type);
        }
    }

    protected function addNewJob($event, $url, $scope, $commandLine)
    {
        $model = $this->job->newInstance();
        $model->command_line = $commandLine .
                               $this->generator->generateUrl($url) .
                               $this->generator->generateDestination($event->project, $event->inspection) .
                               $this->generator->generateParameters($event->inspection->scopes, $scope->name);
        $model->inspection()->associate($event->inspection);
        $model->url()->associate($url);
        $model->scope()->associate($scope);
        $model->save();
    }

    protected function generateJobByType($event, $type)
    {
        $urls = $event->project->urls()->active()->byType($type)->get();
        $scopes = $this->generator->getByType($type);
        foreach ($scopes as $scope) {
            foreach ($urls as $url) {
                $commandLine = $this->generator->generateCommand($event->inspection->scopes, $scope->name);
                if (!is_null($commandLine)) {
                    $this->addNewJob($event, $url, $scope, $commandLine);
                }
            }
        }
    }
}
