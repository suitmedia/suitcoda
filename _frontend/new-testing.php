<?php include '_include/head.php'; ?>

    <?php include '_include/header.php'; ?>

    <main>
        <div class="container">
            <h1 class="title">Create New Testing</h1>

            <form action="">

                <div class="bzg">
                    <div class="bzg_c" data-col="s12,m2">
                        <label for="testing-url">URL :</label>
                    </div>
                    <div class="bzg_c" data-col="s12,m10">
                        <input id="testing-url" class="form-input form-input--block block" type="text">
                    </div>
                </div>
                
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
                                <input type="checkbox" name="codequality" value="html">
                                HTML Validation
                            </label> <br>
                            <label>
                                <input type="checkbox" name="codequality" value="css">
                                CSS Validation
                            </label> <br>
                            <label>
                                <input type="checkbox" name="codequality" value="js">
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

                <button class="btn btn--primary">
                    Test
                </button>
            </form>
        </div>
    </main>

    <?php include '_include/footer.php'; ?>
        
    
<?php include '_include/script.php'; ?>
