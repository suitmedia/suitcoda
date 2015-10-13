<?php include '_include/head.php'; ?>

    <div class="site">
        <main class="main bg-grey site-content">
            <div class="block-up block">
                <div class="container">
                    <div class="text-center">
                        <img class="block" src="assets/img/logo.png" alt="">
                        <h1 class="title">An automated tool to measure website's quality</h1>
                        <h2 class="subtitle block">Sign in to Suitcoda</h2>
                    </div>

                    <div class="box box-form">
                        <form class="cf" action="" data-validate>
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,l4">
                                    <label class="form-label" for="login-user">Username :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,l8">
                                    <input id="login-user" class="form-input form-input--block" type="text" required> <br>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,l4">
                                    <label class="form-label" for="login-pass">Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,l8">
                                    <input id="login-pass" class="form-input form-input--block" type="password" required> <br>
                                </div>
                            </div>

                            <div class="bzg">
                                <div class="bzg_c" data-col="s12,l8" data-offset="l4">
                                    <!-- input captcha here -->
                                    <img src="assets/img/captcha.png" alt=""> <br>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,l4">
                                    <label class="form-label" for="login-captcha">Captcha :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,l8">
                                    <input id="login-captcha" class="form-input form-input--block" type="text" required> <br>
                                </div>
                            </div>
                            
                            <label class="float-left form-label" for="login-remember">
                                <input id="login-remember" type="checkbox">
                                <span>Remember me</span>
                            </label>

                            <button class="btn btn--regular btn--primary float-right">Log in</button>
                        </form>
                    </div>

                    <br>
                    
                    <div class="text-center">
                        <a href="forgot-password.php">
                            Forgot password?
                        </a>
                    </div>
                </div>
            </div>
        </main>
            
        <?php include '_include/footer.php'; ?>
    </div>

<?php include '_include/script.php'; ?>
