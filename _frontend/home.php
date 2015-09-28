<?php include '_include/head.php'; ?>

    <header class="header">
        <div class="container cf">
            <img class="header-logo" src="assets/img/logo-header.png" alt="">
            
            <ul class="header-list cf">
                <li>
                    <a class="notif text-grey" href="#">
                        <div class="notif__icon">
                            <span class="fa fa-bell"></span>
                        </div>
                        <span class="notif__count">2</span>
                    </a>
                    <ul class="notif-list">
                        <li>
                            <a href="#">
                                Testing #20 on Suitcoda Project has done tested.
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Testing #20 on Suitcoda Project has done tested.
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Testing #20 on Suitcoda Project has done tested.
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="user-avatar" href="#">
                        <img src="assets/img/pp.png" alt="">
                    </a>
                    <ul class="user-menu">
                        <li>
                            <a href="#">
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

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
                        <a class="box box--block cf" href="#">
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
    </main>

    <footer class="footer">
        <div class="container">
            <span>Copyright &copy; blablabla</span>
        </div>
    </footer>
        
    
<?php include '_include/script.php'; ?>
