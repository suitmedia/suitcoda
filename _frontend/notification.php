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
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
