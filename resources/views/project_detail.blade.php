@extends('_layouts.pages')

@section('title', 'Project Detail')

@section('main-content')
    @parent
    <main class="main site-content">
        <h1 class="sr-only">Project Detail</h1>
        <div class="container">
            <nav>
                <ul class="project-nav">
                    <li class="project-nav__tab"> 
                        <a class="active" href="#overview">
                            <b>
                                <span class="fa fa-bar-chart"></span>
                                <span class="hide-on-mobile">Overview</span>
                            </b>
                        </a>
                    </li>
                    <li class="project-nav__tab"> 
                        <a class="" href="#activity">
                            <b>
                                <span class="fa fa-code"></span>
                                <span class="hide-on-mobile">Activity</span>
                            </b>
                        </a>
                    </li>
                    <li class="project-nav__tab active"> 
                        <a class="" href="#issues">
                            <b>
                                <span class="fa fa-exclamation-triangle"></span>
                                <span class="hide-on-mobile">Issues</span>
                            </b>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- overview project, chart -->
            <section id="overview" class="project-content project-content--show">
                <h2 class="sr-only">Project Overview</h2>
                <div class="project-chart" data-graph="{{ route('project.graph', $project) }}"></div>
            </section>
            
            <!-- activity, Inspection list, status -->
            <section id="activity" class="project-content">
                <h2 class="sr-only">Project Activity</h2>
                <div class="flex-project">
                    <div class="flex-project__item flex-project__item-main block cf">
                        <h2 class="subtitle float-left fix-margin block-half">Inspection List</h2>
                        @if ($project->is_crawlable == false)
                        <button class="btn-new-testing btn btn--grey btn--regular float-right"><small>New Inspection</small></button> <br>
                        @endif
                        @if (count($project->inspections) == 0)
                        <!-- if no Inspection yet -->
                        <span class="empty-state">There is no Inspection yet.</span>
                        @else
                        <ul class="list-nostyle">
                            @foreach ($project->inspections->reverse() as $inspection)
                                <li>
                                    <a class="box box-testing block" href="#">
                                        <div class="box-testing__detail">
                                            <div class="bzg">
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <b>Inspection #{{ $inspection->sequence_number }}</b>
                                                </div>
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <div class="text-red">
                                                        <span class="fa fa-exclamation-triangle"></span>
                                                        <span>250 Issues</span>
                                                    </div>
                                                </div>
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <div class="text-grey">
                                                        <span class="fa fa-clock-o"></span>
                                                        <span>{{ $inspection->updated_at }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="label label--orange">Performance</span>
                                            <span class="label label--red">Code Quality</span>
                                            <span class="label label--blue">SEO</span>
                                            <span class="label label--green">Security</span>
                                        </div>

                                        <div class="box-testing__percent">
                                            <span>
                                                <b>Overall : </b> 80%
                                            </span>
                                            <span>
                                                <b>Performance : </b> 80%
                                            </span>
                                            <span>
                                                <b>Code Quality : </b> 80%
                                            </span>
                                            <span>
                                                <b>SEO : </b> 80%
                                            </span>
                                            <span>
                                                <b>Security : </b> 80%
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
                                    Overall 
                                    <span class="text-red">(10)</span> 
                                </b> 
                            </div>
                            <div class="progress" data-percent="80">
                                <div class="progress__bar"></div>
                            </div>
                            <span class="float-right">80%</span>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Performance 
                                    <span class="text-red">(4)</span> 
                                </b> 
                            </div>
                            <div class="progress" data-percent="70">
                                <div class="progress__bar"></div>
                            </div>
                            <span class="float-right">70%</span>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Code Quality 
                                    <span class="text-red">(2)</span> 
                                </b> 
                            </div>
                            <div class="progress" data-percent="15">
                                <div class="progress__bar"></div>
                            </div>
                            <span class="float-right">15%</span>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    SEO 
                                    <span class="text-red">(3)</span> 
                                </b> 
                            </div>
                            <div class="progress" data-percent="63">
                                <div class="progress__bar"></div>
                            </div>
                            <span class="float-right">63%</span>
                        </div>
                        <div class="block cf">
                            <div class="progress-title">
                                <b>
                                    Social Media 
                                    <span class="text-red">(1)</span> 
                                </b> 
                            </div>
                            <div class="progress" data-percent="30">
                                <div class="progress__bar"></div>
                            </div>
                            <span class="float-right">30%</span>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- create new Inspection -->
            <section id="newtesting" class="project-content">
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
                                                <input type="checkbox" name="scopes[]" value="{{ (int)$subScope->code }}">
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
            
            <!-- issues details -->
            <section id="issues" class="project-content">
                <h2 class="sr-only">Inspection Issues</h2>

                <!-- if there's no Inspection yet -->
                <span class="empty-state">There is no Inspection yet.</span>

                <h3 class="subtitle">Inspection #20</h3>
                <select name="" id="" class="form-input block">
                    <option value="performance">Performance</option>
                    <option value="codequality">Code Quality</option>
                    <option value="seo">SEO</option>
                    <option value="socialmedia">Social Media</option>
                </select>

                <!-- if there's no issue -->
                <span class="empty-state">There is no issue found.</span>
                
                <ul class="list-nostyle">
                    <?php for ($i=0; $i < 10; $i++) { ?>
                        <li class="block">
                            <div class="box issue cf">
                                <span class="label label--orange block-half">type of error</span>
                                <div class="text-grey float-right">
                                    <span class="fa fa-clock-o"></span>                    
                                    <time>5 minutes ago</time>
                                </div>
                                <br>
                                <a class="issue__url block-half" href="#">http://blablabla.blebleble</a>
                                <br>
                                <span class="issue__message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis sint, deserunt magni facilis quis vitae possimus ipsa sapiente doloribus quae.</span>
                                <button class="btn-show-code float-right">
                                    <span class="fa"></span>
                                </button>
                                <div class="issue__code">
<pre class="line-numbers" data-line="30-35">
<code class="language-javascript">
(function(){

if (typeof self === 'undefined' || !self.Prism || !self.document || !document.querySelector) {
return;
}

function $$(expr, con) {
return Array.prototype.slice.call((con || document).querySelectorAll(expr));
}

function hasClass(element, className) {
className = " " + className + " ";
return (" " + element.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1
}

// Some browsers round the line-height, others don't.
// We need to test for it to position the elements properly.
var isLineHeightRounded = (function() {
var res;
return function() {
    if(typeof res === 'undefined') {
        var d = document.createElement('div');
        d.style.fontSize = '13px';
        d.style.lineHeight = '1.5';
        d.style.padding = 0;
        d.style.border = 0;
        d.innerHTML = '&nbsp;<br />&nbsp;';
        document.body.appendChild(d);
        // Browsers that round the line-height should have offsetHeight === 38
        // The others should have 39.
        res = d.offsetHeight === 38;
        document.body.removeChild(d);
    }
    return res;
}
}());

function highlightLines(pre, lines, classes) {
var ranges = lines.replace(/\s+/g, '').split(','),
    offset = +pre.getAttribute('data-line-offset') || 0;

var parseMethod = isLineHeightRounded() ? parseInt : parseFloat;
var lineHeight = parseMethod(getComputedStyle(pre).lineHeight);

for (var i=0, range; range = ranges[i++];) {
    range = range.split('-');
                
    var start = +range[0],
        end = +range[1] || start;
    
    var line = document.createElement('div');
    
    line.textContent = Array(end - start + 2).join(' \n');
    line.className = (classes || '') + ' line-highlight';

//if the line-numbers plugin is enabled, then there is no reason for this plugin to display the line numbers
if(!hasClass(pre, 'line-numbers')) {
  line.setAttribute('data-start', start);

  if(end > start) {
    line.setAttribute('data-end', end);
  }
}

    line.style.top = (start - offset - 1) * lineHeight + 'px';

//allow this to play nicely with the line-numbers plugin
if(hasClass(pre, 'line-numbers')) {
  //need to attack to pre as when line-numbers is enabled, the code tag is relatively which screws up the positioning
  pre.appendChild(line);
} else {
  (pre.querySelector('code') || pre).appendChild(line);
}
}
}

function applyHash() {
var hash = location.hash.slice(1);

// Remove pre-existing temporary lines
$$('.temporary.line-highlight').forEach(function (line) {
    line.parentNode.removeChild(line);
});

var range = (hash.match(/\.([\d,-]+)$/) || [,''])[1];

if (!range || document.getElementById(hash)) {
    return;
}

var id = hash.slice(0, hash.lastIndexOf('.')),
    pre = document.getElementById(id);
    
if (!pre) {
    return;
}

if (!pre.hasAttribute('data-line')) {
    pre.setAttribute('data-line', '');
}

highlightLines(pre, range, 'temporary ');

document.querySelector('.temporary.line-highlight').scrollIntoView();
}

var fakeTimer = 0; // Hack to limit the number of times applyHash() runs

Prism.hooks.add('complete', function(env) {
var pre = env.element.parentNode;
var lines = pre && pre.getAttribute('data-line');

if (!pre || !lines || !/pre/i.test(pre.nodeName)) {
    return;
}

clearTimeout(fakeTimer);

$$('.line-highlight', pre).forEach(function (line) {
    line.parentNode.removeChild(line);
});

highlightLines(pre, lines);

fakeTimer = setTimeout(applyHash, 1);
});

addEventListener('hashchange', applyHash);

})();
</code>
</pre>
                                </div>
                            </div>
                                
                        </li>
                    
                    <?php } ?>

                </ul>
            </section>


        </div>
    </main>
@stop