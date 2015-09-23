<?php include '_include/head.php'; ?>

    <div class="text-center block-up block">
        <div class="container">
            <img class="block" src="assets/img/logo.png" alt="">
            <h1 class="title">An automated tool to measure website's quality</h1>
            <h2 class="subtitle">Sign in to Suitcoda</h2>

            <div class="box box--login">
                <form class="cf" action="">
                    <label class="sr-only" for="login-user">Username</label>
                    <input id="login-user" class="form-input form-input--block" placeholder="username" type="text"> <br>

                    <label class="sr-only" for="login-pass">Password</label>
                    <input id="login-pass" class="form-input form-input--block block" placeholder="password" type="password"> <br>
                    
                    <img src="assets/img/captcha.png" alt=""> <br>

                    <label class="sr-only" for="login-captcha">Captcha</label>
                    <input id="login-captcha" class="form-input form-input--block block" placeholder="input the text above" type="text"> <br>
                    
                    <label class="float-left" for="login-remember">
                        <input id="login-remember" type="checkbox">
                        <span>Remember me</span>
                    </label>

                    <button class="btn btn--regular btn--primary float-right">Log in</button>
                </form>
            </div>

            <a href="#">
                Forgot password?
            </a>
        </div>
    </div>
        
    
<?php include '_include/script.php'; ?>
