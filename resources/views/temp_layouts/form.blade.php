@extends('temp_layouts.base')

@section('title')
    Form
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @yield('form-heading')
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('form-body')
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@stop