@extends('_layouts.pages')

@section('title', 'Manage Account')

@section('main-content')
    @parent
    <main class="main site-content block-up">
        <div class="container">
            <h1 class="title">Manage Account</h1>
            <div class="bzg">
                <div class="bzg_c" data-col="s12,m6">
                    <a href="{{ route('user.create') }}">
                        <div class="box-dashed box--tall block">
                            <span class="fa fa-plus"></span>
                            <span>Create New Account</span>
                        </div>
                    </a>
                </div>
                @foreach ($models as $model)
                    <div class="bzg_c block" data-col="s12,m6">
                        <div class="box box--block cf">
                            <div class="box__thumbnail box__thumbnail--fixed-height">
                                <span class="text-big">
                                    {{ $model->getInitials() }}
                                </span>
                            </div>
                            <div class="box__desc text-ellipsis">
                                <b>{{ $model->name }}</b> <br>
                                <span>Role : {{ $model->getAdminName() }}</span> <br>
                                <span>Last Login : {{ $model->last_login_at }}</span> <br>
                                <a class="btn btn--primary btn--small" href="{{ route('user.edit', $model) }}">
                                    Edit
                                </a>
                            </div>
                            @if (!$model->isAdmin())
                                {!! Form::model($model, ['route' => ['user.destroy', $model], 'method' => 'DELETE']) !!}
                                    <button type="submit" class="btn box__close" data-confirm="Do you want to delete this account?">
                                        <span class="fa fa-times"></span>
                                    </button>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                @endforeach                
            </div>
        </div>
    </main>
@stop