<?php include '_include/head.php'; ?>

    <div class="site">

        <main class="main site-content">
            <div class="bg-grey">
                <div class="text-center block-up block-double">
                    <div class="container">
                        
                        <h1 class="title block-double block-up">Change your password</h1>

                        <div class="box box-form box-form--wide block-quad">
                            <form action="" data-validate>
                                <div class="block">
                                    <label for="new-pass" class="sr-only">New Password :</label>
                                    <input id="new-pass" class="form-input form-input--block" placeholder="New password" type="password" required>
                                </div>

                                <div class="block">
                                    <label for="new-pass-conf" class="sr-only">Confirm New Password :</label>
                                    <input id="new-pass-conf" class="form-input form-input--block" placeholder="Confirm new password" type="password" required>
                                </div>
                                
                                <button class="btn btn--primary btn--regular">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
