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
            <section id="overview" class="project-content project-content--show">
                <div class="project-chart"></div>
            </section>
            
            <!-- activity, testing list, status -->
            <section id="activity" class="project-content">
                <div class="flex-project">
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
            
            <!-- issues details -->
            <section id="issues" class="project-content">
                <h2 class="subtitle">Testing #20</h2>
                <select name="" id="" class="form-input block">
                    <option value="performance">Performance</option>
                    <option value="codequality">Code Quality</option>
                    <option value="seo">SEO</option>
                    <option value="socialmedia">Social Media</option>
                </select>
                
                <ul class="list-nostyle">
                    <?php for ($i=0; $i < 10; $i++) { ?>
                        <li class="block">
                            <div class="box issue cf">
                                <span class="label label--orange block-half">type of error</span>
                                <div class="text-grey float-right">
                                    <span class="fa fa-clock-o"></span>                    
                                    <time>5 minutes ago</time>
                                </div>
                                <a class="issue__url block-half" href="#">http://blablabla.blebleble</a>
                                <span class="issue__message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis sint, deserunt magni facilis quis vitae possimus ipsa sapiente doloribus quae.</span>
                                <button class="btn-show-code float-right">
                                    <span class="fa fa-chevron-down"></span>
                                </button>
                                <div class="issue__code">
                                    <pre class="brush: js; ruler: true">
},
progressBar: function () {
    var opt = {
        animation : false
    }
    var $progress = $('.progress');
    var $progressBar = $('.progress__bar');

    $('.progressbar').barIndicator(opt);
    for (var i = 0; i < $progress.length; i++) {
        var $progressValue = $progress.eq(i).attr('data-percent');
        $progressBar.eq(i).css('width', $progressValue+'%');
    }
}

};
                                    </pre>
                                </div>
                            </div>
                                
                        </li>
                    
                    <?php } ?>

                </ul>


            </section>
        </div>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
