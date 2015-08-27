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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->models->all();

        return view('temp_layouts.group_index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->models;
        $permissions = config('permissions');
        return view('temp_layouts.group_create', compact('model', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $model = $this->models->newInstance();
        $model->fill($request->except('permissions'));
        if (is_array($request->get('permissions')) || is_object($request->get('permissions'))) {
            foreach ($request->get('permissions') as $value) {
                $model->addPermission($value);
            }
        }
        $model->save();

        return redirect()->route('group.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\View\View
     */
    public function edit($key)
    {
        $model = $this->find($key);
        $permissions = config('permissions');

        return view('temp_layouts.group_edit', compact('model', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  string  $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GroupRequest $request, $key)
    {
        $model = $this->find($key);

        $model->fill($request->except('permissions'));
        if (is_array($request->get('permissions')) || is_object($request->get('permissions'))) {
            $model->permissions = [];
            foreach ($request->get('permissions') as $value) {
                $model->addPermission($value);
            }
        }
        $model->save();

        return redirect()->route('group.index');
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
        return redirect()->route('group.index');
    }

    /**
     * Find operation
     * @param  string $key
     * @return Suitcoda\Model\Group
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
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
