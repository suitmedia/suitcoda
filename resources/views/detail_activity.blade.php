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
                                    <a class="box box-testing block" href="{{ route('detail.issue', [$project->slug, $inspection->sequence_number, $inspection->scopeList->first()->name]) }}">
                                        <div class="box-testing__detail">
                                            <div class="bzg">
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <b>Inspection #{{ $inspection->sequence_number }}</b>
                                                </div>
                                                <div class="bzg_c" data-col="s12,m4">
                                                @if ($inspection->status != '2')
                                                    <div class="text-{{ $inspection->statusTextColor }}">
                                                        <span>{{ $inspection->statusName }}</span>
                                                    </div>
                                                @else
                                                    <div class="text-red">
                                                        <span class="fa fa-exclamation-triangle"></span>
                                                        <span>{{ $inspection->issues }} Issues</span>
                                                    </div>
                                                @endif
                                                </div>
                                                <div class="bzg_c" data-col="s12,m4">
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
                                                <b>Error Rate : </b> {{ $inspection->score }}
                                            </span>
                                            <span>
                                                <b>Performance : </b> {{ $inspection->getScoreByCategory('Performance') }}
                                            </span>
                                            <span>
                                                <b>Code Quality : </b> {{ $inspection->getScoreByCategory('Code Quality') }}
                                            </span>
                                            <span>
                                                <b>SEO : </b> {{ $inspection->getScoreByCategory('SEO') }}
                                            </span>
                                            <span>
                                                <b>Social Media : </b> {{ $inspection->getScoreByCategory('Social Media') }}
                                            </span>
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
                                    <span class="text-red">({{ $project->lastCompletedInspectionIssues }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->lastCompletedInspectionScore }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->lastCompletedInspectionScore }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Performance 
                                    <span class="text-red">({{ $project->getLastCompletedInspectionIssueByCategory('Performance') }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->getLastCompletedInspectionScoreByCategory('Performance') }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->getLastCompletedInspectionScoreByCategory('Performance') }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Code Quality 
                                    <span class="text-red">({{ $project->getLastCompletedInspectionIssueByCategory('Code Quality') }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->getLastCompletedInspectionScoreByCategory('Code Quality') }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->getLastCompletedInspectionScoreByCategory('Code Quality') }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    SEO 
                                    <span class="text-red">({{ $project->getLastCompletedInspectionIssueByCategory('SEO') }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->getLastCompletedInspectionScoreByCategory('SEO') }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->getLastCompletedInspectionScoreByCategory('SEO') }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Social Media 
                                    <span class="text-red">({{ $project->getLastCompletedInspectionIssueByCategory('Social Media') }})</span> 
                                </b> 
                                <span class="float-right">{{ $project->getLastCompletedInspectionScoreByCategory('Social Media') }}%</span>
                            </div>
                            <div class="progress" data-percent="{{ $project->getLastCompletedInspectionScoreByCategory('Social Media') }}">
                                <div class="progress__bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </main>
@stop