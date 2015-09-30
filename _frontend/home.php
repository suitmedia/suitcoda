<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <div class="bg-grey">
        <div class="container">
            <form class="search" action="">
                <label for="search-project" class="search__label"><span class="fa fa-search"></span></label>
                <input id="search-project" class="search__input form-input" type="text" placeholder="search...">
            </form>
        </div>
    </div>

    <main class="block-up">
        <div class="container">
            <div class="bzg">
                <?php for ($i=0; $i < 10; $i++) { ?>
                    <div class="bzg_c block" data-col="s12,m6">
                        <a class="box box--block cf" href="project.php">
                            <div class="box__thumbnail">
                                <span>Testing #12</span> <br>
                                <b class="text-big">80%</b>
                            </div>
                            <div class="box__desc">
                                <b>Project Name</b> <br>
                                <span>Lastest update : </span> <time>23/09/2015 12.34</time> <br>
                                <span>Status : </span> <b class="text-orange">On Progress</b>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>                        
        </div>

        <a class="btn-newproject" href="#">
            <span class="fa fa-plus"></span>
        </a>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
