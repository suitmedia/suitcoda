<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main bg-grey site-content">
            <div class="block-up block">
                <div class="container">
                    
                    <h1 class="title text-center block block-up">Create New Account</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="" data-validate>
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-name" class="form-label">Name :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="acc-name" class="form-input form-input--block" type="text" required>
                                </div>
                            </div>
                            
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-username" class="form-label">Username :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="acc-username" class="form-input form-input--block" type="text" required>
                                </div>
                            </div>
                            
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-email" class="form-label">Email :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="acc-email" class="form-input form-input--block" type="text" required>
                                </div>
                            </div>
                            
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-pass" class="form-label">Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="acc-pass" class="form-input form-input--block" type="password" required>
                                </div>
                            </div>
                            
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-confpass" class="form-label">Confirm Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="acc-confpass" class="form-input form-input--block" type="password" required>
                                </div>
                            </div>
                            
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="acc-role" class="form-label">Role :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <select id="acc-role" class="form-input form-input--block" name="" id="" required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn--primary btn--regular">
                                    Save
                                </button>

                                <a class="btn btn--secondary btn--regular" href="manage-user.php">
                                    Discard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
