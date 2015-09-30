<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <main>
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
            <section id="overview" class="project-content">
                <div class="project-chart"></div>
            </section>
            
            <!-- activity, testing list, status -->
            <section id="activity" class="project-content">
                <div class="flex">
                    <div class="item item-main block cf">
                        <h2 class="subtitle float-left">Testing List</h2>
                        <a class="btn btn--grey btn--regular float-right" href="new-testing.php">New Testing</a> <br>
                        <ul class="list-nostyle">
                            <?php for ($i=0; $i < 10; $i++) { ?>
                                <li>
                                    <a class="box box-testing block" href="#">
                                        <div class="box-testing__detail">
                                            <div class="bzg">
                                                <div class="bzg_c" data-col="s12,m4">
                                                    <b>Testing #16</b>
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
                                                        <span>5 minutes ago</span>
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
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="item item-side block">
                        <h3>Lastest Testing Status</h3>
                        <div class="progressbar-wrapper block-half">
                            <b>
                                Overall 
                                <span class="text-red">(10)</span> 
                            </b> 
                            <div class="progressbar">80</div>
                        </div>
                        <div class="progressbar-wrapper block-half">
                            <b>
                                Performance 
                                <span class="text-red">(4)</span> 
                            </b> 
                            <div class="progressbar">70</div>
                        </div>
                        <div class="progressbar-wrapper block-half">
                            <b>
                                Code Quality 
                                <span class="text-red">(2)</span> 
                            </b> 
                            <div class="progressbar">15</div>
                        </div>
                        <div class="progressbar-wrapper block-half">
                            <b>
                                SEO 
                                <span class="text-red">(3)</span> 
                            </b> 
                            <div class="progressbar">63</div>
                        </div>
                        <div class="progressbar-wrapper block-half">
                            <b>
                                Social Media 
                                <span class="text-red">(1)</span> 
                            </b> 
                            <div class="progressbar">17</div>
                        </div>
                    </div>
                </div>

            </section>
            
            <!-- issues details -->
            <section id="issues" class="project-content">
                <h2 class="subtitle">Issue List</h2>
            </section>
        </div>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
