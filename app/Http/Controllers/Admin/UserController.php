<?php

namespace Suitcoda\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Suitcoda\Http\Requests\UserRequest;
use Suitcoda\Model\User as Model;
use Suitcoda\Http\Controllers\Controller;
use Suitcoda\Model\Group as Roles;

class UserController extends Controller
{
    protected $models;

    public function __construct(Model $model)
    {
        $this->models = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->models->all();

        return view('temp_layouts.user_index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->models;
        $roles = Roles::all();

        return view('temp_layouts.user_create', compact('model', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $model = $this->models->newInstance();
        $model->fill($request->except('roles'));
        $model->save();

        $role = \Sentinel::findRoleByName($request->get('roles'));
        $model->roles()->attach($role);

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\View\View
     */
    public function edit($key)
    {
        $model = $this->find($key);
        $roles = Roles::all();

        return view('temp_layouts.user_edit', compact('model', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $key)
    {
        $model = $this->find($key);
        if ($model->roles()->first() !== null) {
            $role = \Sentinel::findRoleByName($model->roles()->first()->name);
            $model->roles()->detach($role);
        }

        $model->fill($request->except('roles'));
        $model->save();

        $role = \Sentinel::findRoleByName($request->get('roles'));
        $model->roles()->attach($role);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($key)
    {
        $model = $this->find($key);

        if ($model->roles()->first() !== null) {
            $role = \Sentinel::findRoleByName($model->roles()->first()->name);
            $model->roles()->detach($role);
        }
        
        $model->delete();

        return redirect()->route('user.index');
    }

    /**
     * Find operation
     * @param  int $key
     * @return Suitcoda\Model\Group
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function find($key)
    {
        $result = \Sentinel::findById($key);

        if (empty($result)) {
            return abort(404);
        }
        return $result;
    }
}
