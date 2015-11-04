<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <div class="bg-grey block">
                <div class="container">
                    <form class="search" action="">
                        <label for="search-project" class="search__label"><span class="fa fa-search"></span></label>
                        <input id="search-project" class="search__input form-input" type="text" placeholder="search...">
                    </form>
                </div>
            </div>

            <div class="container block-up">
                <h1>Project List</h1>
                <div class="bzg">
                    <div class="bzg_c" data-col="s12,m6">
                        <a href="new-project.php">
                            <div class="box-dashed block">
                                <span class="fa fa-plus"></span>
                                <span>Create New Project</span>
                            </div>
                        </a>
                    </div>
                    <?php for ($i=0; $i < 3; $i++) { ?>
                        <div class="bzg_c block" data-col="s12,m6">
                            <a class="box box--block cf" href="project.php">
                                <div class="box__thumbnail">
                                    <span>Inspection #000</span> <br>
                                    <b class="text-big">80%</b>
                                </div>
                                <div class="box__desc">
                                    <div class="text-ellipsis">
                                        <b>Project Name</b>
                                    </div>
                                    <span>Lastest update : </span> <time>23/09/2015 12.34</time> <br>
                                    <span>Status : </span> <b class="text-green">Completed</b>
                                </div>
                            </a>
                        </div>
                        <div class="bzg_c block" data-col="s12,m6">
                            <a class="box box--block cf" href="project.php">
                                <div class="box__thumbnail">
                                    <span>inspection #000</span> <br>
                                    <b class="text-big">80%</b>
                                </div>
                                <div class="box__desc">
                                    <div class="text-ellipsis">
                                        <b>Project Name Lorem ipsum dolor sit amet.</b>
                                    </div>
                                    <span>Lastest update : </span> <time>23/09/2015 12.34</time> <br>
                                    <span>Status : </span> <b class="text-orange">On Progress</b>
                                </div>
                            </a>
                        </div>
                        <div class="bzg_c block" data-col="s12,m6">
                            <a class="box box--block cf" href="project.php">
                                <div class="box__thumbnail">
                                    <span>inspection #000</span> <br>
                                    <b class="text-big">80%</b>
                                </div>
                                <div class="box__desc">
                                    <div class="text-ellipsis">
                                        <b>Project Name</b>
                                    </div>
                                    <span>Lastest update : </span> <time>23/09/2015 12.34</time> <br>
                                    <span>Status : </span> <b class="text-red">Stopped</b>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>                        
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
