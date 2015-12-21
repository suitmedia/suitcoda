<nav>
    <ul class="project-nav">
        <li class="project-nav__tab"> 
            <a class="{{ $active == 0 ? 'active' : '' }}" href="{{ route('detail.overview', $project->slug) }}">
                <b>
                    <span class="fa fa-bar-chart"></span>
                    <span class="hide-on-mobile">Overview</span>
                </b>
            </a>
        </li>
        <li class="project-nav__tab"> 
            <a class="{{ $active == 1 ? 'active' : '' }}" href="{{ route('detail.activity', $project->slug) }}">
                <b>
                    <span class="fa fa-code"></span>
                    <span class="hide-on-mobile">Activity</span>
                </b>
            </a>
        </li>
        <li class="project-nav__tab active"> 
            <a class="{{ $active == 2 ? 'active' : '' }}" href="{{ is_null($lastInspection) ? '#' : route('detail.issue', [$project->slug, $lastInspection->sequence_number, $project->inspections()->latestCompleted()->first()->scopeList->first()->name]) }}">
                <b>
                    <span class="fa fa-exclamation-triangle"></span>
                    <span class="hide-on-mobile">Latest Issue</span>
                </b>
            </a>
        </li>
    </ul>
</nav>