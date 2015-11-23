<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <h1 class="sr-only">Project Detail</h1>
            <div class="container">
                
                <?php include '_include/projectNav.php'; ?>
                
                <!-- activity, testing list, status -->
                <section class="project-content">
                    <h2 class="sr-only">Project Activity</h2>
                    <div class="flex-project">
                        <div class="flex-project__item flex-project__item-main block cf">
                            <h2 class="subtitle float-left fix-margin">Testing List</h2>
                            <a class="btn-new-testing btn btn--grey btn--regular float-right" href="new-inspection.php">
                                <small>New Inspection</small>
                            </a> <br>
                            
                            <!-- if no testing yet -->
                            <span class="empty-state">There is no testing yet.</span>

                            <ul class="list-nostyle">
                                <?php for ($i=0; $i < 10; $i++) { ?>
                                    <li>
                                        <a class="box box-testing block" href="issue.php">
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
                                                    <b>Error Rate : </b> 80%
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

                        <div class="flex-project__item flex-project__item-side block">
                            <h3>Lastest Inspection Status</h3>
                            <div class="block cf">
                                <div class="progress-title">
                                    <b>
                                        Error Rate
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
                
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
        
        
    
<?php include '_include/script.php'; ?>
