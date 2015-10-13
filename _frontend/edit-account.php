<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main bg-grey site-content">
            <div class="block-up block">
                <div class="container">
                    
                    <h1 class="title text-center block block-up">Edit Account</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="" data-validate>
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-name" class="form-label">Name :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="edit-name" class="form-input form-input--block" value="Christine Teoriman" type="text" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-username" class="form-label">Username :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="edit-username" class="form-input form-input--block" value="cteoriman" type="text" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-email" class="form-label">Email :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="edit-email" class="form-input form-input--block" value="aaa@aaa.aaa" type="text" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-pass" class="form-label">Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="edit-pass" class="form-input form-input--block" value="" type="password" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-confpass" class="form-label">Confirm Password :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="edit-confpass" class="form-input form-input--block" value="" type="password" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="edit-role" class="form-label">Role :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <select id="edit-role" class="form-input form-input--block" name="" id="" required>
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
