<?php

namespace Suitcoda\Http\Controllers;

use Suitcoda\Http\Requests\UserCreateRequest;
use Suitcoda\Http\Requests\UserEditRequest;
use Suitcoda\Model\User as Model;
use Suitcoda\Http\Controllers\BaseController;

class UserController extends BaseController
{
    protected $models;

    public function __construct(Model $model)
    {
        parent::__construct();
        $this->models = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->models->allAccount();

        return view('account_index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->models;

        return view('account_create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $model = $this->models->newInstance();
        $model->fill($request->except('password'));
        $model->password = bcrypt($request->input('password'));
        $model->save();

        return redirect()->route('user.index');
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

        return view('account_edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  string  $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserEditRequest $request, $key)
    {
        $model = $this->find($key);
        $model->fill($request->except('password'));
        $model->password = bcrypt($request->input('password'));
        $model->save();

        return redirect()->route('user.index');
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

        return redirect()->route('user.index');
    }

    /**
     * Find operation
     * @param  string $key
     * @return Suitcoda\Model\User
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function find($key)
    {
        $result = $this->models->findOrFailByUrlKey($key);

        if (empty($result)) {
            return abort(404);
        }
        return $result;
    }
}
