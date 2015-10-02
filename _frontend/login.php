<?php include '_include/head.php'; ?>

    <div class="bg-grey">
        <div class="text-center block-up block">
            <div class="container">
                <img class="block" src="assets/img/logo.png" alt="">
                <h1 class="title">An automated tool to measure website's quality</h1>
                <h2 class="subtitle block">Sign in to Suitcoda</h2>

                <div class="box box-form">
                    <form class="cf" action="" data-validate>
                        <div class="block-half">
                            <label class="sr-only" for="login-user">Username</label>
                            <input id="login-user" class="form-input form-input--block" placeholder="username" type="text" required> <br>
                        </div>
                        
                        <div class="block-half">
                            <label class="sr-only" for="login-pass">Password</label>
                            <input id="login-pass" class="form-input form-input--block" placeholder="password" type="password" required> <br>
                        </div>
                        
                        <img src="assets/img/captcha.png" alt=""> <br>

                        <div class="block-half">
                            <label class="sr-only" for="login-captcha">Captcha</label>
                            <input id="login-captcha" class="form-input form-input--block" placeholder="input the text above" type="text" required> <br>
                        </div>
                        
                        <label class="float-left" for="login-remember">
                            <input id="login-remember" type="checkbox">
                            <span>Remember me</span>
                        </label>

                        <button class="btn btn--regular btn--primary float-right">Log in</button>
                    </form>
                </div>

                <br>

                <a href="#">
                    Forgot password?
                </a>
            </div>
        </div>
    </div>
        
    
<?php include '_include/script.php'; ?>
