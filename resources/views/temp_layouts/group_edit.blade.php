@extends('temp_layouts.form')

@section('title')
    Group @parent
@stop

@section('form-heading')
    Group Edit @parent
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
    <form method="POST" action="{{ route('group.update', $model) }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $model->id }}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $model->name }}" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ $model->slug }}" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Permissions</label>
            <select name="permissions[]" multiple="multiple" class="form-control">
              @foreach ($permissions as $key => $permission)
                  <option value="{{ $key }}">{{ $permission }}</option>
              @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-default">Submit Button</button>
        <button type="reset" class="btn btn-default">Reset Button</button>
        <a class="btn btn-default">Back</a>
    </form>
@stop