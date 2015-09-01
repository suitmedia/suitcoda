@extends('temp_layouts.form')

@section('title')
    User @parent
@stop

@section('form-heading')
    User Create @parent
@stop

@section('form-body')
    <form method="POST" action="{{ route('user.store') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter text">
            {{-- <p class="help-block">Example block-level help text here.</p> --}}
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="Enter text">
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
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-default">Submit Button</button>
        <button type="reset" class="btn btn-default">Reset Button</button>
        <a class="btn btn-default">Back</a>
    </form>
@stop