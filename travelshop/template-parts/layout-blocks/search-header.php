<?php
//@todo die inline styles sorgen für einen sauberen ladevorgang. Diese Styles noch auslagern ins SASS

?>
<section class="layout-block layout-block-search-header">

    <div class="layout-block-search-header--search">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                <?php require  get_stylesheet_directory().'/template-parts/pm-search/search-bar.php';?>
                </div>
            </div>
        </div>
    </div>
    
</section>