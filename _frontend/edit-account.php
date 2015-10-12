<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main bg-grey site-content">
            <div class="text-center block-up block">
                <div class="container">
                    
                    <h1 class="title block block-up">Edit Account</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="" data-validate>
                            <div class="block-half">
                                <label for="edit-name" class="sr-only">Name :</label>
                                <input id="edit-name" class="form-input form-input--block" value="Christine Teoriman" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="edit-username" class="sr-only">Username :</label>
                                <input id="edit-username" class="form-input form-input--block" value="cteoriman" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="edit-email" class="sr-only">Email :</label>
                                <input id="edit-email" class="form-input form-input--block" value="aaa@aaa.aaa" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="edit-pass" class="sr-only">Password :</label>
                                <input id="edit-pass" class="form-input form-input--block" value="asd" type="password" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="edit-confpass" class="sr-only">Confirm Password :</label>
                                <input id="edit-confpass" class="form-input form-input--block" value="asd" type="password" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="edit-role" class="sr-only">Role :</label>
                                <select id="edit-role" class="form-input form-input--block" name="" id="" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <button class="btn btn--primary btn--regular">
                                Save
                            </button>

                            <a class="btn btn--secondary btn--regular" href="manage-user.php">
                                Discard
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
    
<?php include '_include/script.php'; ?>
