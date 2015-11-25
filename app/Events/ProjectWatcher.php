<?php

namespace Suitcoda\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Suitcoda\Events\Event;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;

class ProjectWatcher extends Event
{
    use SerializesModels;

    public $project;

    public $inspection;

    /**
     * Create a new event instance.
     *
     * @param Suitcoda\Model\Project $project []
     * @param Suitcoda\Model\Inspection $inspection []
     * @return void
     */
    public function __construct(Project $project, Inspection $inspection)
    {
        $this->project = $project;
        $this->inspection = $inspection;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    // public function broadcastOn()
    // {
    //     return [];
    // }
}
