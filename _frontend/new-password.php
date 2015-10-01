<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <main>
        <div class="bg-grey">
            <div class="text-center block-up block-double">
                <div class="container">
                    
                    <h1 class="title block-double block-up">Change your password</h1>

                    <div class="box box-form box-form--wide block-quad">
                        <form action="" data-validate="yes">
                            <label for="new-pass" class="sr-only">New Password :</label>
                            <input id="new-pass" class="form-input form-input--block block" placeholder="New password" type="password" required>
                            <label for="new-pass-conf" class="sr-only">Confirm New Password :</label>
                            <input id="new-pass-conf" class="form-input form-input--block block" placeholder="Confirm new password" type="password" required>
                            
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
        
    
<?php include '_include/script.php'; ?>
