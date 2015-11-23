<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <h1 class="sr-only">Project Detail</h1>
            <div class="container">
                <?php include '_include/projectNav.php'; ?>
                
                <!-- create new testing -->
                <section id="newtesting" class="project-content">
                    <h2 class="subtitle">Create New Testing</h2>
                    <form id="form-inspection-options" action="">                    
                        <div class="bzg">
                            <div class="bzg_c" data-col="s12,m6">
                                <fieldset class="box box-fieldset box--block block">
                                    <legend>
                                        <b>Performance</b>
                                    </legend>
                                    <label>
                                    <input type="checkbox" name="performance" value="pagespeed">
                                        Google Page Speed
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="performance" value="yslow">
                                        Yahoo YSlow
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="performance" value="httpheader">
                                        Optimize HTTP Header
                                    </label> <br>
                                </fieldset>
                            </div>
                            <div class="bzg_c" data-col="s12,m6">
                                <fieldset class="box box-fieldset box--block block">
                                    <legend>
                                        <b>Code Quality</b>
                                    </legend>
                                    <label>
                                        <input type="checkbox" name="codequality" value="html" checked disabled>
                                        HTML Validation
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="codequality" value="css" checked disabled>
                                        CSS Validation
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="codequality" value="js" checked disabled>
                                        JS Validation
                                    </label> <br>
                                </fieldset>
                            </div>
                            <div class="bzg_c" data-col="s12,m6">
                                <fieldset class="box box-fieldset box--block block">
                                    <legend>
                                        <b>SEO</b>
                                    </legend>
                                    <label>
                                        <input type="checkbox" name="seo" value="title">
                                        Title Tag Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="header">
                                        Header Tag Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="footer">
                                        Footer Tag Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="script">
                                        Script Tag Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="favicon">
                                        Favicon Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="aria">
                                        ARIA Landmark Checking
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="alt">
                                        Alt Text on Image
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="i18n">
                                        Internationalization - i18n
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="seo" value="meta">
                                        Necessary Meta Tag Checking
                                    </label> <br>
                                </fieldset>
                            </div>
                            <div class="bzg_c" data-col="s12,m6">
                                <fieldset class="box box-fieldset box--block block">
                                    <legend>
                                        <b>Social Media</b>
                                    </legend>
                                    <label>
                                        <input type="checkbox" name="socmed" value="og">
                                        Open Graph Protocol
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="socmed" value="twitter">
                                        Twitter Cards
                                    </label> <br>
                                    <label>
                                        <input type="checkbox" name="socmed" value="fb">
                                        Facebook Insights
                                    </label> <br>
                                </fieldset>
                            </div>
                        </div>
                        
                        <div class="block-half">
                            <label class="block">
                                <input type="checkbox" class="check-all" data-target="form-inspection-options">
                                Check All
                            </label>
                        </div>

                        <button class="btn btn--primary btn--regular">
                            Test
                        </button>
                    </form>
                </section>
                
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
        
        
    
<?php include '_include/script.php'; ?>
