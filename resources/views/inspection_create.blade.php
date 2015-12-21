@extends('_layouts.pages')

@section('title', 'Create Inspection')

@section('main-content')
    <main class="main site-content">
        <h1 class="sr-only">Project Detail</h1>
        <div class="container">
            @include('_include.navigation')
            
            <!-- create new testing -->
            <section class="project-content">
                <h2 class="subtitle">Create New Inspection</h2>
                <form id="form-inspection-options" method="POST" action="{{ route('inspection.store', $project->slug) }}">   
                {!! csrf_field() !!}                 
                    <div class="bzg">
                        @foreach ($scopes as $key => $scope)
                            <div class="bzg_c" data-col="s12,m6">
                                <fieldset class="box box-fieldset box--block block">
                                    <legend>
                                        <b>{{ $key }}</b>
                                    </legend>
                                    @foreach ($scope as $value)
                                        @foreach ($value->subScopes as $subScope)
                                            <label>
                                                {!! Form::checkbox('scopes[]', (int)$subScope->code, null, ($key == "Code Quality") ? ['checked', 'onclick' => 'return false'] : []) !!}
                                                {{ $subScope->name }}
                                            </label> <br>
                                            
                                        @endforeach
                                    @endforeach
                                </fieldset>
                            </div>
                        @endforeach
                    </div>

                    <div class="block-half">
                        <label class="block">
                            <input type="checkbox" class="check-all" name="check-all" data-target="form-inspection-options">
                            Check All
                        </label>
                    </div>

                    <button type="submit" class="btn btn--primary btn--regular">
                        Inspect
                    </button>
                </form>
            </section>
            
        </div>
    </main>
@stop