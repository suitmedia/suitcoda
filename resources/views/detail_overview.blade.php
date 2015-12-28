@extends('_layouts.pages')

@section('title', 'Overview')

@section('main-content')
    @parent
    <main class="main site-content">
        <h1 class="sr-only">Project Detail</h1>
        <div class="container">
            @include('_include.navigation')
            
            <!-- overview project, chart -->
            <section class="project-content">
                <h2 class="sr-only">Project Overview</h2>
                <div class="project-chart" data-graph="{{ route('detail.graph', $project) }}"></div>
            </section>
            
        </div>
    </main>
@stop