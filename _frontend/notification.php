<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <div class="container">
                <h1 class="title">Notification</h1>
                <ul class="all-notif list-nostyle block">
                    <!-- empty state -->
                    <!-- <li>
                        <span class="empty-state">You have no notification.</span>
                    </li> -->
                    <?php for ($i=0; $i < 20; $i++) { ?>
                        <li>
                            <a href="#">
                                <span>Testing #20 on Suitmedia Project has done tested.</span> <br>
                                <time class="text-grey">5 minutes ago</time>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <ul class="pagination">
                    <li>
                        <a href="#">Prev</a>
                    </li>
                    <li>
                        <a class="active" href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">Next</a>
                    </li>
                </ul>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
