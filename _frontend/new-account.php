<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <main>
        <div class="bg-grey">
            <div class="text-center block-up block">
                <div class="container">
                    
                    <h1 class="title block block-up">Create New Account</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="">
                            <label for="acc-name" class="sr-only">Name :</label>
                            <input id="acc-name" class="form-input form-input--block block-half" placeholder="Name" type="text">
                            
                            <label for="acc-username" class="sr-only">Username :</label>
                            <input id="acc-username" class="form-input form-input--block block-half" placeholder="Username" type="text">
                            
                            <label for="acc-email" class="sr-only">Email :</label>
                            <input id="acc-email" class="form-input form-input--block block-half" placeholder="Email" type="text">
                            
                            <label for="acc-pass" class="sr-only">Password :</label>
                            <input id="acc-pass" class="form-input form-input--block block-half" placeholder="Password" type="text">
                            
                            <label for="acc-confpass" class="sr-only">Confirm Password :</label>
                            <input id="acc-confpass" class="form-input form-input--block block-half" placeholder="Confirm Password" type="text">
                            
                            <label for="acc-role" class="sr-only">Role :</label>
                            <select id="acc-role" class="form-input form-input--block block" name="" id="">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>

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
        </div>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
