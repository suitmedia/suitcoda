<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <main class="main">
        <div class="bg-grey">
            <div class="text-center block-up block">
                <div class="container">
                    
                    <h1 class="title block block-up">Create New Account</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="" data-validate>
                            <div class="block-half">
                                <label for="acc-name" class="sr-only">Name :</label>
                                <input id="acc-name" class="form-input form-input--block" placeholder="Name" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="acc-username" class="sr-only">Username :</label>
                                <input id="acc-username" class="form-input form-input--block" placeholder="Username" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="acc-email" class="sr-only">Email :</label>
                                <input id="acc-email" class="form-input form-input--block" placeholder="Email" type="text" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="acc-pass" class="sr-only">Password :</label>
                                <input id="acc-pass" class="form-input form-input--block" placeholder="Password" type="password" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="acc-confpass" class="sr-only">Confirm Password :</label>
                                <input id="acc-confpass" class="form-input form-input--block" placeholder="Confirm Password" type="password" required>
                            </div>
                            
                            <div class="block-half">
                                <label for="acc-role" class="sr-only">Role :</label>
                                <select id="acc-role" class="form-input form-input--block" name="" id="" required>
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
        </div>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
