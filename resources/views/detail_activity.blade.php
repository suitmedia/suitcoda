@extends('_layouts.pages')

@section('title', 'Activity')

@section('main-content')
    @parent
    <main class="main site-content">
        <h1 class="sr-only">Project Detail</h1>
        <div class="container">
            
            @include('_include.navigation')
            
            <!-- activity, testing list, status -->
            <section class="project-content">
                <h2 class="sr-only">Project Activity</h2>
                <div class="flex-project">
                    <div class="flex-project__item flex-project__item-main block cf">
                        <h2 class="subtitle float-left fix-margin block-half">Inspection List</h2>
                        @if ($project->is_crawlable == false)
                        <a class="btn-new-testing btn btn--grey btn--regular float-right" href="{{ route('inspection.create', $project->slug) }}"><small>New Inspection</small></a> <br>
                        @endif
                        @if (count($project->inspections) == 0)
                        <!-- if no Inspection yet -->
                        <span class="empty-state">There is no Inspection yet.</span>
                        @else
                        <ul class="list-nostyle">
                            @foreach ($project->inspections->reverse() as $inspection)
                                <li>
                                    <a class="box box-testing block" href="{{ $inspection->isCompleted() ? route('detail.issue', [$project->slug, $inspection->sequence_number, $inspection->scopeList->first()->name]) : '#' }}">
                                        <div class="box-testing__detail">
                                            <div class="bzg">
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <b>Inspection #{{ $inspection->sequence_number }}</b>
                                                </div>
                                                <div class="bzg_c" data-col="s12,m5">
                                                @if ($inspection->isCompleted())
                                                    <div class="text-red">
                                                        <span class="fa fa-exclamation-triangle"></span>
                                                        <span>{{ $inspection->issueError }} Errors</span>
                                                        <span>{{ $inspection->issueWarning }} Warnings</span>
                                                    </div>
                                                @else
                                                    <div class="text-{{ $inspection->statusTextColor }}">
                                                        <span>{{ $inspection->statusName }}</span>
                                                    </div>
                                                @endif
                                                </div>
                                                <div class="bzg_c" data-col="s12,m3">
                                                    <div class="text-grey">
                                                        <span class="fa fa-clock-o"></span>
                                                        <span>{{ $inspection->updated_at }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($inspection->scopeList as $category)
                                                <span class="label label--{{ $category->label_color }}">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                        <div class="box-testing__percent">
                                            <span>
                                                <b>Error Rate : </b> {{ $inspection->score . ($inspection->score == '-' ? '' : '%') }}
                                            </span>
                                            @foreach ($categories as $category)
                                                <span>
                                                    <b>{{ $category->name }} : </b> {{ $inspection->getScoreByCategory($category->slug) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>

                    <div class="flex-project__item flex-project__item-side block">
                        <h3>Lastest Inspection Status</h3>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Error Rate 
                                    <span class="text-red">({{ $project->lastCompletedInspectionUrlPercentage }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->lastCompletedInspectionScore }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->lastCompletedInspectionScore }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                        @foreach ($categories as $category)
                            <div class="block cf">
                                <div class="progress-title">
                                    <b>
                                        {{ $category->name }}
                                        <span class="text-red">({{ $project->getLastCompletedInspectionUrlPercentageByCategory($category->slug) }})</span> 
                                    </b> 
                                    <span class="float-right">{{ $project->getLastCompletedInspectionScoreByCategory($category->slug) }}%</span>
                                </div>
                                <div class="progress" data-percent="{{ $project->getLastCompletedInspectionScoreByCategory($category->slug) }}">
                                    <div class="progress__bar"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            
        </div>
    </main>
@stop