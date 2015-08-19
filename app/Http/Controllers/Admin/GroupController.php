<?php

namespace Suitcoda\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Suitcoda\Http\Requests\GroupRequest;
use Suitcoda\Model\Group as Model;
use Suitcoda\Http\Controllers\Controller;

class GroupController extends Controller
{
    protected $models;

    public function __construct(Model $models)
    {
        $this->models = $models;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = $this->models->all();

        return view('temp_layouts.group_index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = $this->models;
        return view('temp_layouts.group_create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(GroupRequest $request)
    {
        $model = $this->models->newInstance();
        $model->fill($request->all());
        $model->save();

        return redirect()->route('group.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function edit($key)
    {
        $model = $this->find($key);

        return view('temp_layouts.group_edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @return Response
     */
    public function update(GroupRequest $request, $key)
    {
        $model = $this->find($key);

        $model->fill($request->all());
        $model->save();

        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return Response
     */
    public function destroy($key)
    {
        $model = $this->find($key);

        $model->delete();
        return redirect()->route('group.index');
    }

    /**
     * Find operation
     * @param  string $key
     * @return void
     */
    protected function find($key)
    {
        $result = \Sentinel::findRoleBySlug($key);

        if (empty($result)) {
            return abort(404);
        }
        return $result;
    }
}
