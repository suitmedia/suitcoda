<?php

namespace Suitcoda\Http\Controllers;

use Illuminate\Http\Request;
use Suitcoda\Http\Requests\ProjectRequest;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;

class ProjectController extends BaseController
{
    protected $project;

    protected $scope;

    /**
     * Class constructor
     *
     * @param Suitcoda\Model\Project  $project []
     * @param Suitcoda\Model\Scope $scope []
     */
    public function __construct(Project $project, Scope $scope)
    {
        parent::__construct();
        $this->project = $project;
        $this->scope = $scope;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = \Auth::user()->projects;

        return view('home', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project_create', [ 'project' => $this->project ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Suitcoda\Http\Requests\ProjectRequest  $request []
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $project = $this->project->newInstance();
        $project->fill($request->all());
        $project->user()->associate(\Auth::user());
        $project->save();

        return redirect()->route('home');
    }

    /**
     * Show detail information for project
     *
     * @param  string $key []
     * @return \Illuminate\Http\Response
     */
    public function detail($key)
    {
        $project = $this->find($key);
        $scopes = $this->scope->all()->groupBy('category');

        return view('project_detail', compact('project', 'scopes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $key []
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($key)
    {
        $model = $this->find($key);
        $model->delete();
        return redirect()->route('home');
    }

    /**
     * Find operation
     *
     * @param  string $key []
     * @return Suitcoda\Model\User
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function find($key)
    {
        $result = \Auth::user()->projects()->findOrFailByUrlKey($key);

        if (empty($result)) {
            return abort(404);
        }
        return $result;
    }

    /**
     * Show json data for chart
     *
     * @param  string $key []
     * @return \Illuminate\Http\Response
     */
    public function graph($key)
    {
        $project = $this->find($key);
        return response()->json($this->generateJson($project));
    }

    /**
     * Generate json data for graph
     *
     * @param  Suitcoda\Model\Project $project []
     * @return array
     */
    protected function generateJson($project)
    {
        $graphData = [];
        $count = 0;
        $listGraph = [
            'Overall',
            'Performance',
            'Code Quality',
            'Social Media'
        ];
        $graphData = array_add($graphData, 'title', $project->name);
        $graphData = array_add($graphData, 'series', []);
        $graphData = array_add($graphData, 'xAxis', []);

        foreach ($listGraph as $graph) {
            array_set($series, $count . '.name', $graph);
            array_set($series, $count . '.data', [1000, 40]);
            $count++;
        }
        array_set($graphData, 'series', $series);
        foreach ($project->inspections as $inspection) {
            array_push($graphData['xAxis'], '#' . $inspection->sequence_number);
        }
        return $graphData;
    }

    /**
     * Search project by name
     * @param  Request $request []
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $key = $request->input('key');
        $projects = $this->project->search($key)->get();

        return view('project_search', compact('projects'));
    }
}
