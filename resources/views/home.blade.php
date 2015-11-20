@extends('_layouts.pages')

@section('title', 'Home')

@section('main-content')
    @parent
    <main class="main site-content">
        <div class="bg-grey block">
            <div class="container">
                <form class="search" action="">
                    <label for="search-project" class="search__label"><span class="fa fa-search"></span></label>
                    <input id="search-project" class="search__input form-input" type="text" placeholder="search...">
                </form>
            </div>
        </div>

        <div class="container block-up">
            <h1>Project List</h1>
            <div class="bzg">
                <div class="bzg_c" data-col="s12,m6">
                    <a href="{{ route('project.create') }}">
                        <div class="box-dashed block">
                            <span class="fa fa-plus"></span>
                            <span>Create New Project</span>
                        </div>
                    </a>
                </div>
                @foreach ($projects as $project)
                    <div class="bzg_c block" data-col="s12,m6">
                        <a class="box box--block cf" href="{{ route('project.detail', $project->slug) }}">
                            <div class="box__thumbnail">
                            @if (!$project->inspections()->getAllByProjectId($project->id)->isEmpty())
                                <span>Inspection #{{ $project->inspections()->getLatestByProjectId($project->id)->sequence_number }}</span> <br>
                            @else
                                <span>Inspection -</span> <br>
                            @endif
                                <b class="text-big">80%</b>
                            </div>
                            <div class="box__desc">
                                <div class="text-ellipsis">
                                    <b>{{ $project->name }}</b>
                                </div>
                                <span>Url : </span> {{ $project->main_url }} <br>
                                <span>Lastest update : </span> <time>{{ $project->updated_at }}</time> <br>
                                <span>Status : </span> <b class="text-green">Completed</b>
                            </div>
                            {!! Form::model($project, ['route' => ['project.destroy', $project], 'method' => 'DELETE']) !!}
                                <button type="submit" class="btn box__close" data-confirm="Do you want to delete this project?">
                                    <span class="fa fa-times"></span>
                                </button>
                            {!! Form::close() !!}
                        </a>
                    </div>
                @endforeach
            </div>                        
        </div>
    </main>
@stop