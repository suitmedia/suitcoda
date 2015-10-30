<?php

namespace Suitcoda\Http\Controllers;

use Suitcoda\Model\Project as Model;
use Suitcoda\Http\Requests\ProjectRequest;

class ProjectController extends BaseController
{
    protected $model;

    /**
     * Class constructor
     *
     * @param Model  $model
     */
    public function __construct(Model $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = \Auth::user()->projects;

        return view('home', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project_create', [ 'model' => $this->model ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $model = $this->model->newInstance();
        $model->fill($request->all());
        $model->user()->associate(\Auth::user());
        $model->save();

        return redirect()->route('home');
    }
}
