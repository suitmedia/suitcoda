<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content block-up">
            <div class="container">
                <h1 class="title">Manage User</h1>
                <div class="bzg">
                    <div class="bzg_c" data-col="s12,m6">
                        <a href="new-account.php">
                            <div class="box-newuser box--tall block">
                                <span class="fa fa-plus"></span>
                                <span>Create New Account</span>
                            </div>
                        </a>
                    </div>

                    <?php for ($i=0; $i < 10; $i++) { ?>
                        <div class="bzg_c block" data-col="s12,m6">
                            <div class="box box--block cf" href="project.php">
                                <div class="box__thumbnail box--tall">
                                    <span class="text-big">
                                        CT
                                    </span>
                                </div>
                                <div class="box__desc text-ellipsis">
                                    <b>Christine Teoriman</b> <br>
                                    <span>christine.teoriman@gmail.com</span> <br>
                                    <span>Username : cteoriman</span> <br>
                                    <span>Last Login : </span> <time>23/09/2015 12.34</time> <br>
                                    <select name="" id="">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <form action="">
                                    <button class="btn box__close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>

<?php include '_include/script.php'; ?>
