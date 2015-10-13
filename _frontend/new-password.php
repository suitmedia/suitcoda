<?php include '_include/head.php'; ?>

    <div class="site">

        <main class="main bg-grey site-content">
            <div class="block-up block-double">
                <div class="container">
                    
                    <h1 class="title text-center block-double block-up">Change your password</h1>

                    <div class="box box-form box-form--wide block-quad">
                        <form action="" data-validate>
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m5">
                                    <label for="new-pass" class="form-label">New Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m7">
                                    <input id="new-pass" class="form-input form-input--block" type="password" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m5">
                                    <label for="new-pass-conf" class="form-label">Confirm New Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m7">
                                    <input id="new-pass-conf" class="form-input form-input--block" type="password" required>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn--primary btn--regular">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
