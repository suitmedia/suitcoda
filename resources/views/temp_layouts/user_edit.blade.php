@extends('temp_layouts.form')

@section('title')
    User @parent
@stop

@section('form-heading')
    User Edit @parent
@stop

@section('form-body')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="POST" action="{{ route('user.update', $model) }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $model->id }}">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ $model->username }}" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ $model->email }}" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Roles</label>
            <select name="roles" class="form-control">
              @foreach ($roles as $role)
                  <option name="roles" value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-default">Submit Button</button>
        <button type="reset" class="btn btn-default">Reset Button</button>
        <a class="btn btn-default">Back</a>
    </form>
@stop