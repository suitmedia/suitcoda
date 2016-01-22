<?php

namespace Suitcoda\Http\Controllers;

use Illuminate\Http\Request;
use Suitcoda\Http\Requests\ProjectRequest;
use Suitcoda\Model\Project;

class ProjectController extends BaseController
{
    protected $project;

    /**
     * Class constructor
     *
     * @param Suitcoda\Model\Project  $project []
     */
    public function __construct(Project $project)
    {
        parent::__construct();
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = \Auth::user()->projects()->orderBy('updated_at', 'desc')->get();

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
