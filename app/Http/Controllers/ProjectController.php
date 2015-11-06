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

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $key
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
     * @param  string $key
     * @return Suitcoda\Model\Project
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function find($key)
    {
        $result = $this->model->findOrFailByUrlKey($key);

        if (empty($result)) {
            return abort(404);
        }
        return $result;
    }
}
