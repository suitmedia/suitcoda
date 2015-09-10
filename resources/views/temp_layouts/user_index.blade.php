@extends('temp_layouts.base')

@section('custom-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.responsive.css') }}">
@stop

@section('custom-js')
    @parent
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
@stop

@section('title')
    User
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $model)
                                <tr>
                                    <td>{{ $model->id }}</td>
                                    <td>{{ $model->username }}</td>
                                    <td>{{ $model->email }}</td>
                                    <td>
                                        <form method="post" action="{{ route('user.destroy', $model) }}">
                                            <a href="{{ route('user.edit', $model) }}" class="btn btn-success">Edit</a>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pull-right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add New</a>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<!-- /.row -->
@stop