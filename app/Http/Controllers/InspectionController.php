<?php

namespace Suitcoda\Http\Controllers;

use Illuminate\Http\Request;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Events\ProjectWatcher;

class InspectionController extends BaseController
{
    protected $inspection;

    protected $project;

    /**
     * Class constructor
     *
     * @param Inspection  $inspection
     */
    public function __construct(Inspection $inspection, Project $project)
    {
        parent::__construct();
        $this->model = $inspection;
        $this->project = $project;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['scopes' => 'required']);

        $project = $this->project->findBySlug($request->route()->parameters()['project']);

        $sumScopes = 0;
        foreach ($request->input('scopes') as $scopeValue) {
            $sumScopes |= $scopeValue;
        }

        $inspection = $this->model->newInstance();
        if (!$inspection->getLatestByProjectId($project->id)->get()->isEmpty() &&
            $inspection->getLatestByProjectId($project->id)->sequence_number > 0) {
            $inspection->sequence_number = $inspection->getLatestByProjectId($project->id)->sequence_number + 1;
        } else {
            $inspection->sequence_number = 1;
        }
        $inspection->scopes = $sumScopes;
        $project->inspections()->save($inspection);

        $project->update(['is_crawlable' => true]);

        event(new ProjectWatcher($project, $inspection));

        return redirect()->route('project.detail', $project->slug);
    }
}
