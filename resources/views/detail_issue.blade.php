@extends('_layouts.pages')

@section('title', 'Issue')

@section('main-content')
{{-- {{ dd($inspection) }} --}}
    @parent
    <main class="main site-content">
        <h1 class="sr-only">Project Detail</h1>
        <div class="container">

            @include('_include.navigation')
            
            <!-- issues details -->
            <section class="project-content">
                <h2 class="sr-only">Inspection Issues</h2>

                <div class="block-half">
                    <a class="text-orange" href="{{ route('detail.activity', $project->slug) }}">
                        <span class="fa fa-angle-left"></span> Back to Inspection List
                    </a>
                </div>
                <div class="bzg">
                    <div class="bzg_c" data-col="s6">
                        <h3 class="subtitle">Inspection #{{ $inspection->sequence_number }}</h3>
                    </div>
                    <div class="bzg_c" data-col="s6">
                    <form method="POST", action="{{ route('detail.issue.category', [$project->slug, $inspection->sequence_number]) }}">
                    {{ csrf_field() }}
                        <select name="category" id="category" class="form-input block float-right" onchange="submit()">
                        @foreach ($inspection->scopeList as $category)
                            <option value="{{ $category->name }}" {{ strcmp($selectedCategory, $category->name) == 0 ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </form>
                    </div>
                </div>
                @foreach ($issues as $issue)
                <ul class="list-nostyle">
                    
                        <li class="block">
                            <div class="box issue cf">
                                <span class="label label--{{ ($issue->isError()) ? 'red' : 'orange' }} block-half">{{ $issue->type }}</span>
                                <div class="text-grey float-right">
                                    <span class="fa fa-clock-o"></span>                    
                                    <time>{{ $issue->created_at }}</time>
                                </div>
                                <br>
                                <a class="issue__url block-half" href="#">{{ $issue->url }}</a>{{ $issue->issue_line ? ', Line : ' . $issue->issue_line : '' }}
                                <br>
                                <span class="issue__message">{!! nl2br($issue->description) !!}</span>
                                @if ($issue->issue_line)
                                <button class="btn-show-code float-right">
                                    <span class="fa"></span>
                                </button>
                                <div class="issue__code">
<pre class="line-numbers" data-line="{{ $issue->issue_line }}">
<code class="language-{{ $issue->jobInspect->url->type }}">{{ @gzinflate($issue->jobInspect->url->body_content) }}</code>
</pre>
                                </div>
                                @endif
                            </div>
                                
                        </li>
                    
                    

                </ul>
                @endforeach

                {!! $pagination->render() !!}
            </section>


        </div>
    </main>
@stop