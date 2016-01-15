@extends('_layouts.pages')

@section('title', 'Home')

@section('main-content')
    @parent
    <main class="main site-content">
        <div class="bg-grey block">
            <div class="container">
                <form class="search" method="POST" action="{{ route('project.search') }}">
                {!! csrf_field() !!}
                    <label for="search-project" class="search__label"><span class="fa fa-search"></span></label>
                    <input id="search-project" class="search__input form-input" name="key" type="search" placeholder="search..." onsearch="submit()">
                </form>
            </div>
        </div>

        <div class="container block-up">
            <h1>Search</h1>
            <div class="bzg">
            @if ($projects->isEmpty())
                <span class="empty-state">There are no project with the given name.</span>
            @endif
                @foreach ($projects as $project)
                    <div class="bzg_c block" data-col="s12,m6">
                        <a class="box box--block cf" href="{{ route('detail.overview', $project->slug) }}">
                            <div class="box__thumbnail">
                                <span>Error Rate :</span> <br>
                                <b class="text-big">{{ $project->lastInspectionScore }}</b>
                            </div>
                            <div class="box__desc">
                                <div class="text-ellipsis">
                                    <b>{{ $project->name }}</b>
                                </div>
                                <span>Inspection : {{ $project->lastInspectionNumber }}</span> <br>
                                <span>Lastest update : </span> <time>{{ $project->updated_at }}</time> <br>
                                <span>Status : </span> {!! $project->lastInspectionStatus !!}
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