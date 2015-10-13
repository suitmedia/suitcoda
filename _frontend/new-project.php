<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main bg-grey site-content">
            <div class="block-up block">
                <div class="container">
                    
                    <h1 class="title text-center block block-up">Create New Project</h1>

                    <div class="box box-form box-form--wide block">
                        <form action="" data-validate>
                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="project-name" class="form-label">Project Name :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="project-name" class="form-input form-input--block" type="text" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="project-url" class="form-label">Project URL :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <input id="project-url" class="form-input form-input--block" type="text" required>
                                </div>
                            </div>

                            <div class="bzg block-half">
                                <div class="bzg_c" data-col="s12,m4">
                                    <label for="project-desc" class="form-label">Project Description :</label>
                                </div>
                                <div class="bzg_c" data-col="s12,m8">
                                    <textarea id="project-desc" class="form-input form-input--block" rows="7" required></textarea>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn--primary btn--regular">
                                    Save
                                </button>

                                <a class="btn btn--secondary btn--regular" href="home.php">
                                    Cancel
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
