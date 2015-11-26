@extends('_layouts.pages')

@section('title')
    @parent - Create New Project
@stop

@section('main-content')
    @parent
    <main class="main bg-grey site-content">
        <div class="block-up block">
            <div class="container">
                
                <h1 class="title text-center block block-up">Create New Project</h1>

                <div class="box box-form box-form--wide block">
                    <form method="POST" action="{{ route('project.store') }}" data-validate>
                    {!! csrf_field() !!}
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="project-name" class="form-label">Project Name :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="project-name" class="form-input form-input--block" name="name" value="{{ Request::old('name') }}" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="project-url" class="form-label">Project URL :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="project-url" class="form-input form-input--block" name="main_url" value="{{ (empty(Request::old('main_url')) ? $project->main_url : Request::old('main_url')) }}" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('main_url') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn--primary btn--regular">
                                Save
                            </button>

                            <a class="btn btn--secondary btn--regular" href="{{ route('home') }}">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@stop