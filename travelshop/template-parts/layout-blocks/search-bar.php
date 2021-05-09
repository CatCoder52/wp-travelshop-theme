<?php global $colorScheme; ?>
<section class="layout-block layout-block-search-bar">
    <div class="layout-block-search-bar--search <?php echo $colorScheme; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                    <?php require  get_stylesheet_directory().'/template-parts/pm-search/search-bar-plain.php';?>
                </div>
            </div>
        </div>
    </div>
</section>