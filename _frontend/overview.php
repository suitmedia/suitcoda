<?php include '_include/head.php'; ?>

    <div class="site">
        <?php include '_include/header.php'; ?>

        <main class="main site-content">
            <h1 class="sr-only">Project Detail</h1>
            <div class="container">
                <?php include '_include/projectNav.php'; ?>
                
                <!-- overview project, chart -->
                <section class="project-content">
                    <h2 class="sr-only">Project Overview</h2>
                    <div class="project-chart" data-graph="graph-data.json"></div>
                </section>
                
            </div>
        </main>

        <?php include '_include/footer.php'; ?>
    </div>
        
        
    
<?php include '_include/script.php'; ?>
